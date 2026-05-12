<link rel="stylesheet" href="<?php echo WEB_ROOT; ?>admin/inventory/css/inventorytable.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="wrapper">
    <div class="col-12 d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="bi bi-building"></i> Schools</h5>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>School ID</th>
                    <th>School Name</th>
                    <th>Date Created</th>
                    <th>Last Login</th>
                    <th>Total Items</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="schoolsTableBody">
                <tr>
                    <td colspan="7" class="text-center text-muted py-3">Loading schools...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<!-- ─── VIEW ITEMS MODAL ───────────────────────────────────────────────────── -->
<div class="modal fade" id="viewItemsModal" tabindex="-1" aria-labelledby="viewItemsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewItemsModalLabel">
                    <i class="bi bi-building me-2"></i>
                    <span id="modalSchoolName">School Items</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="iatao-table-container">
                    <table class="iatao-table">
                        <thead>
                            <tr>
                                <th rowspan="2">#</th>
                                <th rowspan="2" style="min-width:150px;">ITEM NAME</th>
                                <th rowspan="2" style="min-width:200px;">DESCRIPTION</th>
                                <th rowspan="2" style="width:120px;">PROPERTY NO.</th>
                                <th rowspan="2" style="width:100px;">SERIAL NO.</th>
                                <th rowspan="2" style="width:100px;">ICS NO.</th>
                                <th rowspan="2" style="width:100px;">PROPERTY TYPE</th>
                                <th rowspan="2" style="width:100px;">FUND CLUSTER</th>
                                <th rowspan="2" style="width:100px;">UNIT OF MEASURE</th>
                                <th rowspan="2" style="width:100px;">UNIT VALUE</th>
                                <th rowspan="2" style="width:100px;">QTY/PROPERTY CARD</th>
                                <th rowspan="2" style="width:100px;">QTY/PHYSICAL COUNT</th>
                                <th colspan="2" class="iatao-shortage-header" style="width:140px;">SHORTAGE / OVERAGE</th>
                                <th rowspan="2" style="width:100px;">Issued By</th>
                                <th rowspan="2" style="width:100px;">Date Issued</th>
                                <th rowspan="2" style="width:100px;">Date Received</th>
                                <th rowspan="2" style="width:100px;">Status</th>
                                <th rowspan="2" style="width:100px;">Notes</th>
                            </tr>
                            <tr>
                                <th style="width:70px;">Quantity</th>
                                <th style="width:70px;">Value</th>
                            </tr>
                        </thead>
                        <tbody id="viewItemsTableBody">
                            <tr>
                                <td colspan="19" class="text-center text-muted py-3">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>

// ─── STATUS BADGE ─────────────────────────────────────────────────────────────

function getStatusBadge(status) {
    const map = {
        'Serviceable'            : 'success',
        'Transferred'            : 'info',
        'Stolen'                 : 'danger',
        'Lost'                   : 'danger',
        'Damaged due to calamity': 'warning',
        'For disposal'           : 'secondary',
        'Disposed'               : 'dark',
        'Donated'                : 'primary',
    };
    const color = map[status] ?? 'secondary';
    return status
        ? `<span class="badge bg-${color}">${status}</span>`
        : '—';
}

// ─── LOAD & RENDER SCHOOLS ────────────────────────────────────────────────────

function loadSchools() {
    const tbody = document.getElementById('schoolsTableBody');
    tbody.innerHTML = `<tr><td colspan="7" class="text-center text-muted py-3">Loading schools...</td></tr>`;

    fetch('api/fetch-schools.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderSchools(data.data);
            } else {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center text-danger py-3">${data.message}</td></tr>`;
            }
        })
        .catch(error => {
            console.error('Fetch Schools Error:', error);
            tbody.innerHTML = `<tr><td colspan="7" class="text-center text-danger py-3">Failed to load schools.</td></tr>`;
        });
}

function renderSchools(schools) {
    const tbody = document.getElementById('schoolsTableBody');
    tbody.innerHTML = '';

    if (schools.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7" class="text-center text-muted py-3">No schools found.</td></tr>`;
        return;
    }

    schools.forEach((school, index) => {
        const row = `
            <tr>
                <td>${index + 1}</td>
                <td>${school.s_schoolId ?? '—'}</td>
                <td>${school.s_schoolName ?? '—'}</td>
                <td>${school.s_dateCreated ?? '—'}</td>
                <td>${school.lastLogin ?? '—'}</td>
                <td>
                    <span class="badge bg-primary">${school.total_items ?? 0} item(s)</span>
                </td>
                <td>
                    <button class="btn btn-primary btn-sm"
                        onclick="viewSchoolItems(${school.s_id}, '${school.s_schoolName}')">
                        <i class="bi bi-eye"></i> View Items
                    </button>
                </td>
            </tr>`;
        tbody.insertAdjacentHTML('beforeend', row);
    });
}

// ─── VIEW SCHOOL ITEMS ────────────────────────────────────────────────────────

function viewSchoolItems(s_id, schoolName) {
    const tbody     = document.getElementById('viewItemsTableBody');
    const modalName = document.getElementById('modalSchoolName');

    modalName.textContent = schoolName;
    tbody.innerHTML = `<tr><td colspan="19" class="text-center text-muted py-3">Loading items...</td></tr>`;

    const modal = new bootstrap.Modal(document.getElementById('viewItemsModal'));
    modal.show();

    fetch(`api/fetch-school-items.php?s_id=${s_id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderSchoolItems(data.data);
            } else {
                tbody.innerHTML = `<tr><td colspan="19" class="text-center text-danger py-3">${data.message}</td></tr>`;
            }
        })
        .catch(error => {
            console.error('Fetch School Items Error:', error);
            tbody.innerHTML = `<tr><td colspan="19" class="text-center text-danger py-3">Failed to load items.</td></tr>`;
        });
}

function renderSchoolItems(items) {
    const tbody = document.getElementById('viewItemsTableBody');
    tbody.innerHTML = '';

    if (items.length === 0) {
        tbody.innerHTML = `<tr><td colspan="19" class="text-center text-muted py-3">No items found for this school.</td></tr>`;
        return;
    }

    items.forEach((item, index) => {
        const row = `
            <tr>
                <td class="iatao-center-col">${index + 1}</td>
                <td class="iatao-article-col">${item.si_item ?? '—'}</td>
                <td class="iatao-desc-col">${item.si_description ?? '—'}</td>
                <td class="iatao-center-col">${item.si_propertyNo ?? '—'}</td>
                <td class="iatao-center-col">${item.si_serialNo ?? '—'}</td>
                <td class="iatao-center-col">${item.si_icsNo ?? '—'}</td>
                <td class="iatao-center-col">${item.si_propertyType ?? '—'}</td>
                <td class="iatao-center-col">${item.si_fundCluster ?? '—'}</td>
                <td class="iatao-center-col">${item.si_uMeasurement ?? '—'}</td>
                <td class="iatao-right-col">${item.si_uValue ?? '—'}</td>
                <td class="iatao-center-col">${item.si_propertyCardNo ?? '—'}</td>
                <td class="iatao-center-col">${item.si_physicalCountNo ?? '—'}</td>
                <td class="iatao-center-col">${item.si_SOQuantity ?? '—'}</td>
                <td class="iatao-right-col">${item.si_SOValue ?? '—'}</td>
                <td class="iatao-center-col">${item.si_issuedBy ?? '—'}</td>
                <td class="iatao-center-col">${item.si_dateIssued ?? '—'}</td>
                <td class="iatao-center-col">${item.si_dateReceived ?? '—'}</td>
                <td class="iatao-center-col">${getStatusBadge(item.si_status)}</td>
                <td class="iatao-remarks-col">${item.si_notes ?? '—'}</td>
            </tr>`;
        tbody.insertAdjacentHTML('beforeend', row);
    });
}

// ─── INIT ─────────────────────────────────────────────────────────────────────

document.addEventListener('DOMContentLoaded', loadSchools);

</script>