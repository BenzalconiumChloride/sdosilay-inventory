<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="dashboard-wrapper px-3 py-3">

    <!-- ─── PAGE TITLE ──────────────────────────────────────────────────── -->
    <div class="mb-4">
        <h4 class="mb-0 fw-bold"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>
        <small class="text-white">Inventory overview</small>
    </div>

    <!-- ─── STAT CARDS ──────────────────────────────────────────────────── -->
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-primary bg-opacity-10">
                        <i class="bi bi-box-seam fs-3 text-primary"></i>
                    </div>
                    <div>
                        <div class="text-light small">Total Inventory Items</div>
                        <div class="fw-bold fs-4" id="statTotalItems">—</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-success bg-opacity-10">
                        <i class="bi bi-building fs-3 text-success"></i>
                    </div>
                    <div>
                        <div class="text-light small">Total Schools</div>
                        <div class="fw-bold fs-4" id="statTotalSchools">—</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-warning bg-opacity-10">
                        <i class="bi bi-archive fs-3 text-warning"></i>
                    </div>
                    <div>
                        <div class="text-light small">Total School Items</div>
                        <div class="fw-bold fs-4" id="statTotalSchoolItems">—</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ─── CHARTS ROW ───────────────────────────────────────────────────── -->
    <div class="row g-3 mb-4">

        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header fw-semibold border-bottom">
                    <i class="bi bi-pie-chart me-2 text-primary"></i>Items by Status
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="statusChart" style="max-height:260px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header fw-semibold border-bottom">
                    <i class="bi bi-bar-chart me-2 text-success"></i>Items by Property Type
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="typeChart" style="max-height:260px;"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- ─── FUND CLUSTER + RECENT ITEMS ─────────────────────────────────── -->
    <div class="row g-3">

        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header fw-semibold border-bottom">
                    <i class="bi bi-wallet2 me-2 text-warning"></i>Items by Fund Cluster
                </div>
                <div class="card-body" id="fundClusterList">
                    <div class="text-center text-muted py-3">Loading...</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header fw-semibold border-bottom">
                    <i class="bi bi-clock-history me-2 text-info"></i>Recently Added Items
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Item Name</th>
                                    <th>Property No.</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Date Received</th>
                                </tr>
                            </thead>
                            <tbody id="recentItemsBody">
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">Loading...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


<script>

// ─── CHART INSTANCES ──────────────────────────────────────────────────────────
let statusChartInstance = null;
let typeChartInstance   = null;

// ─── COLORS ───────────────────────────────────────────────────────────────────
const CHART_COLORS = [
    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e',
    '#e74a3b', '#858796', '#5a5c69', '#2e59d9'
];

// ─── STATUS BADGE ─────────────────────────────────────────────────────────────
function getStatusBadge(status) {
    const map = {
        'serviceable'   : 'success',
        'for repair'    : 'warning',
        'unserviceable' : 'danger',
        'not applicable': 'secondary',
    };
    const color = map[(status ?? '').toLowerCase()] ?? 'secondary';
    return status
        ? `<span class="badge bg-${color}">${status}</span>`
        : '<span class="text-muted">—</span>';
}

// ─── LOAD DASHBOARD ───────────────────────────────────────────────────────────
function loadDashboard() {
    fetch('home/api/fetch-dashboard.php')
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Dashboard error:', data.message);
                return;
            }

            const d = data.data;

            // ── Stat Cards
            document.getElementById('statTotalItems').textContent       = d.total_items.toLocaleString();
            document.getElementById('statTotalSchools').textContent     = d.total_schools.toLocaleString();
            document.getElementById('statTotalSchoolItems').textContent = d.total_school_items.toLocaleString();

            // ── Status Chart
            renderStatusChart(d.by_status);

            // ── Property Type Chart
            renderTypeChart(d.by_property_type);

            // ── Fund Cluster List
            renderFundClusterList(d.by_fund_cluster);

            // ── Recent Items
            renderRecentItems(d.recent_items);
        })
        .catch(error => {
            console.error('Fetch Dashboard Error:', error);
        });
}

// ─── STATUS DOUGHNUT CHART ────────────────────────────────────────────────────
function renderStatusChart(data) {
    if (statusChartInstance) statusChartInstance.destroy();

    const labels = data.map(d => d.i_status || 'Unspecified');
    const counts = data.map(d => d.count);

    const ctx = document.getElementById('statusChart').getContext('2d');
    statusChartInstance = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: counts,
                backgroundColor: CHART_COLORS,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
}

// ─── PROPERTY TYPE BAR CHART ──────────────────────────────────────────────────
function renderTypeChart(data) {
    if (typeChartInstance) typeChartInstance.destroy();

    const labels = data.map(d => d.i_propertyType || 'Unspecified');
    const counts = data.map(d => d.count);

    const ctx = document.getElementById('typeChart').getContext('2d');
    typeChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Items',
                data: counts,
                backgroundColor: CHART_COLORS,
                borderRadius: 6,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
}

// ─── FUND CLUSTER LIST ────────────────────────────────────────────────────────
function renderFundClusterList(data) {
    const container = document.getElementById('fundClusterList');

    if (data.length === 0) {
        container.innerHTML = `<div class="text-center text-muted py-3">No data available.</div>`;
        return;
    }

    const max = Math.max(...data.map(d => d.count));

    container.innerHTML = data.map(d => {
        const pct = Math.round((d.count / max) * 100);
        return `
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <span class="small fw-semibold">${d.i_fundCluster}</span>
                    <span class="small text-muted">${d.count} item(s)</span>
                </div>
                <div class="progress" style="height:8px;">
                    <div class="progress-bar bg-warning" style="width:${pct}%"></div>
                </div>
            </div>`;
    }).join('');
}

// ─── RECENT ITEMS TABLE ───────────────────────────────────────────────────────
function renderRecentItems(items) {
    const tbody = document.getElementById('recentItemsBody');

    if (items.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted py-3">No items found.</td></tr>`;
        return;
    }

    tbody.innerHTML = items.map(item => `
        <tr>
            <td>${item.i_item ?? '—'}</td>
            <td>${item.i_propertyNo ?? '—'}</td>
            <td>${item.i_propertyType ?? '—'}</td>
            <td>${getStatusBadge(item.i_status)}</td>
            <td>${item.i_dateReceived ?? '—'}</td>
        </tr>`
    ).join('');
}

// ─── INIT ─────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', loadDashboard);

</script>