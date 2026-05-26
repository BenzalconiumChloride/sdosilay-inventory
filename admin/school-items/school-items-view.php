<?php
$s_id       = isset($_GET['s_id']) && is_numeric($_GET['s_id']) ? (int)$_GET['s_id'] : 0;
$schoolName = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'School';

if (!$s_id) {
    header('Location: index.php');
    exit;
}
?>

<link rel="stylesheet" href="<?php echo WEB_ROOT; ?>admin/inventory/css/inventorytable.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="wrapper container-fluid">

    <!-- ─── HEADER ──────────────────────────────────────────────────────────── -->
    <div class="col-12 d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">
            <i class="bi bi-building me-2"></i><?php echo $schoolName; ?>
        </h5>
        <a href="index.php" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Schools
        </a>
    </div>

    <!-- ─── FILTERS ─────────────────────────────────────────────────────────── -->
    <div class="row g-2 mb-3">
        <div class="col-md-2">
            <input type="text" id="si_filterArticle" class="form-control form-control-sm" placeholder="Article">
        </div>
        <div class="col-md-2">
            <input type="text" id="si_filterPropertyNo" class="form-control form-control-sm" placeholder="Property Number">
        </div>
        <div class="col-md-2">
            <input type="text" id="si_filterSerialNo" class="form-control form-control-sm" placeholder="Serial Number">
        </div>
        <div class="col-md-2">
            <input type="text" id="si_filterIcsNo" class="form-control form-control-sm" placeholder="ICS Number">
        </div>
        <div class="col-md-2">
            <input type="text" id="si_filterFundCluster" class="form-control form-control-sm" placeholder="Fund Cluster">
        </div>
        <div class="col-md-2">
            <input type="text" id="si_filterPropertyType" class="form-control form-control-sm" placeholder="Property Type">
        </div>
    </div>

    <!-- ─── TABLE ───────────────────────────────────────────────────────────── -->
    <div class="iatao-table-container">
        <table class="iatao-table">
            <thead>
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2" style="min-width:150px;">ARTICLE</th>
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

<script>

// ─── STATE ────────────────────────────────────────────────────────────────────

let allSchoolItems = [];
const S_ID = <?php echo $s_id; ?>;

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

// ─── LOAD ITEMS ───────────────────────────────────────────────────────────────

function loadSchoolItems() {
    const tbody = document.getElementById('viewItemsTableBody');
    tbody.innerHTML = `<tr><td colspan="19" class="text-center text-muted py-3">Loading items...</td></tr>`;

    fetch(`api/fetch-school-items.php?s_id=${S_ID}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                allSchoolItems = data.data;
                applyFilters();
            } else {
                tbody.innerHTML = `<tr><td colspan="19" class="text-center text-danger py-3">${data.message}</td></tr>`;
            }
        })
        .catch(error => {
            console.error('Fetch School Items Error:', error);
            tbody.innerHTML = `<tr><td colspan="19" class="text-center text-danger py-3">Failed to load items.</td></tr>`;
        });
}

// ─── FILTERS ──────────────────────────────────────────────────────────────────

function applyFilters() {
    const article      = document.getElementById('si_filterArticle').value.trim().toLowerCase();
    const propertyNo   = document.getElementById('si_filterPropertyNo').value.trim().toLowerCase();
    const serialNo     = document.getElementById('si_filterSerialNo').value.trim().toLowerCase();
    const icsNo        = document.getElementById('si_filterIcsNo').value.trim().toLowerCase();
    const fundCluster  = document.getElementById('si_filterFundCluster').value.trim().toLowerCase();
    const propertyType = document.getElementById('si_filterPropertyType').value.trim().toLowerCase();

    const filtered = allSchoolItems.filter(item => {
        return (
            (!article      || (item.si_item         ?? '').toLowerCase().includes(article))      &&
            (!propertyNo   || (item.si_propertyNo   ?? '').toLowerCase().includes(propertyNo))   &&
            (!serialNo     || (item.si_serialNo     ?? '').toLowerCase().includes(serialNo))     &&
            (!icsNo        || (item.si_icsNo        ?? '').toLowerCase().includes(icsNo))        &&
            (!fundCluster  || (item.si_fundCluster  ?? '').toLowerCase().includes(fundCluster))  &&
            (!propertyType || (item.si_propertyType ?? '').toLowerCase().includes(propertyType))
        );
    });

    renderSchoolItems(filtered);
}

function bindFilters() {
    ['si_filterArticle', 'si_filterPropertyNo', 'si_filterSerialNo',
     'si_filterIcsNo', 'si_filterFundCluster', 'si_filterPropertyType']
        .forEach(id => {
            document.getElementById(id).addEventListener('input', applyFilters);
        });
}

// ─── RENDER ───────────────────────────────────────────────────────────────────

function renderSchoolItems(items) {
    const tbody = document.getElementById('viewItemsTableBody');
    tbody.innerHTML = '';

    if (items.length === 0) {
        tbody.innerHTML = `<tr><td colspan="19" class="text-center text-muted py-3">No items found.</td></tr>`;
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

document.addEventListener('DOMContentLoaded', () => {
    bindFilters();
    loadSchoolItems();
});

</script>