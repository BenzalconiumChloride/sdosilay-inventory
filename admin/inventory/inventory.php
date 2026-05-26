<link rel="stylesheet" type="text/css" href="<?= WEB_ROOT; ?>admin/inventory/css/inventorytable.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="iatao-wrapper">
    <div class="col-12 d-flex justify-content-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
            <i class="bi bi-plus-lg"></i> Add Item
        </button>
    </div>

    <!-- ─── FILTERS ─────────────────────────────────────────────────────────── -->
    <div class="row g-2 mb-3">
        <div class="col-md-2">
            <input type="text" id="filterArticle" class="form-control form-control-sm" placeholder="Article / Equipment">
        </div>
        <div class="col-md-2">
            <input type="text" id="filterPropertyNo" class="form-control form-control-sm" placeholder="Property Number">
        </div>
        <div class="col-md-2">
            <input type="text" id="filterSerialNo" class="form-control form-control-sm" placeholder="Serial Number">
        </div>
        <div class="col-md-2">
            <input type="text" id="filterIcsNo" class="form-control form-control-sm" placeholder="ICS Number">
        </div>
        <div class="col-md-2">
            <input type="text" id="filterFundCluster" class="form-control form-control-sm" placeholder="Fund Cluster">
        </div>
        <div class="col-md-2">
            <input type="text" id="filterPropertyType" class="form-control form-control-sm" placeholder="Property Type">
        </div>
    </div>
    <!-- ──────────────────────────────────────────────────────────────────────── -->

    <div class="iatao-table-container">
        <table class="iatao-table">
            <thead>
                <tr>
                    <th rowspan="2" style="width:80px;">ARTICLE</th>
                    <th rowspan="2" style="min-width:200px;">DESCRIPTION</th>
                    <th rowspan="2" style="width:120px;">PROPERTY NUMBER</th>
                    <th rowspan="2" style="width:65px;">SERIAL NUMBER</th>
                    <th rowspan="2" style="width:65px;">ICS NUMBER</th>
                    <th rowspan="2" style="width:65px;">PROPERTY TYPE</th>
                    <th rowspan="2" style="width:65px;">FUND CLUSTER</th>
                    <th rowspan="2" style="width:65px;">UNIT OF MEASURE</th>
                    <th rowspan="2" style="width:75px;">UNIT VALUE</th>
                    <th rowspan="2" style="width:75px;">QUANTITY/PROPERTY CARD</th>
                    <th rowspan="2" style="width:75px;">QUANTITY/PHYSICAL COUNT</th>
                    <th colspan="2" class="iatao-shortage-header" style="width:140px;">SHORTAGE / OVERAGE</th>
                    <th rowspan="2" style="width:100px;">Date Received</th>
                    <th rowspan="2" style="width:100px;">Issued By</th>
                    <th rowspan="2" style="width:100px;">Issued To</th>
                    <th rowspan="2" style="width:100px;">Date Issued To</th>
                    <th rowspan="2" style="width:100px;">Transferred To</th>
                    <th rowspan="2" style="width:100px;">Date Transferred To</th>
                    <th rowspan="2" style="width:100px;">Status</th>
                    <th rowspan="2" style="width:100px;">Remarks</th>
                    <th rowspan="2" style="width:100px;">Actions</th>
                </tr>
                <tr>
                    <th style="width:70px;">Quantity</th>
                    <th style="width:70px;">Value</th>
                </tr>
            </thead>
            <tbody id="itemsTableBody">
                <tr>
                    <td colspan="22" class="text-center text-muted py-3">Loading items...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addItemModalLabel">Add Item</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="addItemAlert" class="alert d-none" role="alert"></div>
                <form id="addItemForm">

                    <div class="row mb-3">
                        <div class="col-md-4 mb-3">
                            <label for="i_propertyNo" class="form-label">Property Number *</label>
                            <input type="text" class="form-control" id="i_propertyNo" name="i_propertyNo" required placeholder="property #">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="i_serialNo" class="form-label">Serial Number *</label>
                            <input type="text" class="form-control" id="i_serialNo" name="i_serialNo" required placeholder="serial #">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="i_icsNo" class="form-label">ICS Number *</label>
                            <input type="text" class="form-control" id="i_icsNo" name="i_icsNo" required placeholder="ics #">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="i_propertyType" class="form-label">Property Type</label>
                            <input type="text" class="form-control" id="i_propertyType" name="i_propertyType" placeholder="property type">
                        </div>
                        <div class="col-6">
                            <label for="i_fundCluster" class="form-label">Fund Cluster</label>
                            <input type="text" class="form-control" id="i_fundCluster" name="i_fundCluster" placeholder="fund cluster">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="i_item" class="form-label">Article *</label>
                            <input type="text" class="form-control" id="i_item" name="i_item" required placeholder="item name">
                        </div>
                        <div class="col-8">
                            <label for="i_description" class="form-label">Description</label>
                            <textarea class="form-control" id="i_description" name="i_description" rows="1" placeholder="item description"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="i_uMeasurement" class="form-label">Unit of Measure *</label>
                            <input type="text" class="form-control" id="i_uMeasurement" name="i_uMeasurement" required placeholder="unit of measure">
                        </div>
                        <div class="col-md-3">
                            <label for="i_uValue" class="form-label">Unit Value</label>
                            <input type="text" class="form-control" id="i_uValue" name="i_uValue" placeholder="unit value">
                        </div>
                        <div class="col-md-3">
                            <label for="i_propertyCardNo" class="form-label">Quantity/Property Card</label>
                            <input type="text" class="form-control" id="i_propertyCardNo" name="i_propertyCardNo" placeholder="property card qty">
                        </div>
                        <div class="col-md-3">
                            <label for="i_physicalCountNo" class="form-label">Quantity/Physical Count</label>
                            <input type="text" class="form-control" id="i_physicalCountNo" name="i_physicalCountNo" placeholder="physical count qty">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <hr>
                        <label class="form-label text-center">Shortage / Overage</label>
                        <div class="col-6">
                            <label for="i_SOQuantity" class="form-label">Quantity</label>
                            <input type="text" class="form-control" id="i_SOQuantity" name="i_SOQuantity" placeholder="quantity">
                        </div>
                        <div class="col-6">
                            <label for="i_SOValue" class="form-label">Value</label>
                            <input type="text" class="form-control" id="i_SOValue" name="i_SOValue" placeholder="value">
                        </div>
                        <hr class="mt-2">
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="i_dateReceived" class="form-label">Date Received</label>
                            <input type="date" class="form-control" id="i_dateReceived" name="i_dateReceived">
                        </div>
                        <div class="col-6">
                            <label for="i_issuedBy" class="form-label">Issued By</label>
                            <input type="text" class="form-control" id="i_issuedBy" name="i_issuedBy" placeholder="issued by">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="i_issuedTo" class="form-label">Issued To</label>
                            <input type="text" class="form-control" id="i_issuedTo" name="i_issuedTo" placeholder="issued to">
                        </div>
                        <div class="col-6">
                            <label for="i_dateIssued" class="form-label">Date Issued To</label>
                            <input type="date" class="form-control" id="i_dateIssued" name="i_dateIssued">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="i_transferredTo" class="form-label">Transferred To</label>
                            <input type="text" class="form-control" id="i_transferredTo" name="i_transferredTo" placeholder="transferred to">
                        </div>
                        <div class="col-6">
                            <label for="i_dateTransferred" class="form-label">Date Transferred To</label>
                            <input type="date" class="form-control" id="i_dateTransferred" name="i_dateTransferred">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="i_status" class="form-label">Status</label>
                            <select class="form-control" id="i_status" name="i_status">
                                <option value="">Select Status</option>
                                <option value="New">New</option>
                                <option value="Updating">Updating</option>
                                <option value="serviceable">Serviceable</option>
                                <option value="for repair">For Repair</option>
                                <option value="unserviceable">Unserviceable</option>
                                <option value="not applicable">Not Applicable</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="i_notes" class="form-label">Remarks</label>
                            <input type="text" class="form-control" id="i_notes" name="i_notes" placeholder="remarks">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveItemBtn">
                    <span id="saveItemSpinner" class="spinner-border spinner-border-sm d-none me-1" role="status"></span>
                    Save Item
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editItemModalLabel">Edit Item</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="editItemAlert" class="alert d-none" role="alert"></div>
                <form id="editItemForm">
                    <input type="hidden" id="e_id" name="e_id">

                    <div class="row mb-3">
                        <div class="col-md-4 mb-3">
                            <label for="e_propertyNo" class="form-label">Property Number *</label>
                            <input type="text" class="form-control" id="e_propertyNo" name="e_propertyNo" required placeholder="property #">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="e_serialNo" class="form-label">Serial Number *</label>
                            <input type="text" class="form-control" id="e_serialNo" name="e_serialNo" required placeholder="serial #">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="e_icsNo" class="form-label">ICS Number *</label>
                            <input type="text" class="form-control" id="e_icsNo" name="e_icsNo" required placeholder="ics #">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="e_propertyType" class="form-label">Property Type</label>
                            <input type="text" class="form-control" id="e_propertyType" name="e_propertyType" placeholder="property type">
                        </div>
                        <div class="col-6">
                            <label for="e_fundCluster" class="form-label">Fund Cluster</label>
                            <input type="text" class="form-control" id="e_fundCluster" name="e_fundCluster" placeholder="fund cluster">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="e_item" class="form-label">Item Name *</label>
                            <input type="text" class="form-control" id="e_item" name="e_item" required placeholder="item name">
                        </div>
                        <div class="col-8">
                            <label for="e_description" class="form-label">Description</label>
                            <textarea class="form-control" id="e_description" name="e_description" rows="1" placeholder="item description"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="e_uMeasurement" class="form-label">Unit of Measure *</label>
                            <input type="text" class="form-control" id="e_uMeasurement" name="e_uMeasurement" required placeholder="unit of measure">
                        </div>
                        <div class="col-md-3">
                            <label for="e_uValue" class="form-label">Unit Value</label>
                            <input type="text" class="form-control" id="e_uValue" name="e_uValue" placeholder="unit value">
                        </div>
                        <div class="col-md-3">
                            <label for="e_propertyCardNo" class="form-label">Quantity/Property Card</label>
                            <input type="text" class="form-control" id="e_propertyCardNo" name="e_propertyCardNo" placeholder="property card qty">
                        </div>
                        <div class="col-md-3">
                            <label for="e_physicalCountNo" class="form-label">Quantity/Physical Count</label>
                            <input type="text" class="form-control" id="e_physicalCountNo" name="e_physicalCountNo" placeholder="physical count qty">
                        </div>
                    </div>

                    <div class="row mb-3 border rounded-3 p-2 m-1">
                       
                        <label class="form-label text-center">Shortage / Overage</label>
                        <div class="col-6">
                            <label for="e_SOQuantity" class="form-label">Quantity</label>
                            <input type="text" class="form-control" id="e_SOQuantity" name="e_SOQuantity" placeholder="quantity">
                        </div>
                        <div class="col-6">
                            <label for="e_SOValue" class="form-label">Value</label>
                            <input type="text" class="form-control" id="e_SOValue" name="e_SOValue" placeholder="value">
                        </div>
                       
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="e_dateReceived" class="form-label">Date Received</label>
                            <input type="date" class="form-control" id="e_dateReceived" name="e_dateReceived">
                        </div>
                        <div class="col-6">
                            <label for="e_issuedBy" class="form-label">Issued By</label>
                            <input type="text" class="form-control" id="e_issuedBy" name="e_issuedBy" placeholder="issued by">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="e_issuedTo" class="form-label">Issued To</label>
                            <input type="text" class="form-control" id="e_issuedTo" name="e_issuedTo" placeholder="issued to">
                        </div>
                        <div class="col-6">
                            <label for="e_dateIssued" class="form-label">Date Issued To</label>
                            <input type="date" class="form-control" id="e_dateIssued" name="e_dateIssued">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="e_transferredTo" class="form-label">Transferred To</label>
                            <input type="text" class="form-control" id="e_transferredTo" name="e_transferredTo" placeholder="transferred to">
                        </div>
                        <div class="col-6">
                            <label for="e_dateTransferred" class="form-label">Date Transferred To</label>
                            <input type="date" class="form-control" id="e_dateTransferred" name="e_dateTransferred">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="e_status" class="form-label">Status</label>
                            <select class="form-control" id="e_status" name="e_status">
                                <option value="">Select Status</option>
                                <option value="New">New</option>
                                <option value="Updating">Updating</option>
                                <option value="serviceable">Serviceable</option>
                                <option value="for repair">For Repair</option>
                                <option value="unserviceable">Unserviceable</option>
                                <option value="not applicable">Not Applicable</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="e_notes" class="form-label">Remarks</label>
                            <input type="text" class="form-control" id="e_notes" name="e_notes" placeholder="remarks">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateItemBtn">
                    <span id="updateItemSpinner" class="spinner-border spinner-border-sm d-none me-1" role="status"></span>
                    Update Item
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// ─── STATE ───────────────────────────────────────────────────────────────────

let allItems = [];   // master copy; never mutated by filtering

// ─── LOAD & RENDER ITEMS ────────────────────────────────────────────────────

function loadItems() {
    const tbody = document.getElementById('itemsTableBody');
    tbody.innerHTML = `<tr><td colspan="22" class="text-center text-muted py-3">Loading items...</td></tr>`;

    fetch('api/fetch-item.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                allItems = data.data;         // cache full list
                applyFilters();               // render (with any active filters)
            } else {
                tbody.innerHTML = `<tr><td colspan="22" class="text-center text-danger py-3">${data.message}</td></tr>`;
            }
        })
        .catch(error => {
            console.error('Error fetching items:', error);
            tbody.innerHTML = `<tr><td colspan="22" class="text-center text-danger py-3">Failed to load items.</td></tr>`;
        });
}

// ─── FILTER ──────────────────────────────────────────────────────────────────

function applyFilters() {
    const article      = document.getElementById('filterArticle').value.trim().toLowerCase();
    const propertyNo   = document.getElementById('filterPropertyNo').value.trim().toLowerCase();
    const serialNo     = document.getElementById('filterSerialNo').value.trim().toLowerCase();
    const icsNo        = document.getElementById('filterIcsNo').value.trim().toLowerCase();
    const fundCluster  = document.getElementById('filterFundCluster').value.trim().toLowerCase();
    const propertyType = document.getElementById('filterPropertyType').value.trim().toLowerCase();

    const filtered = allItems.filter(item => {
        return (
            (!article      || (item.i_item         ?? '').toLowerCase().includes(article))      &&
            (!propertyNo   || (item.i_propertyNo   ?? '').toLowerCase().includes(propertyNo))   &&
            (!serialNo     || (item.i_serialNo     ?? '').toLowerCase().includes(serialNo))     &&
            (!icsNo        || (item.i_icsNo        ?? '').toLowerCase().includes(icsNo))        &&
            (!fundCluster  || (item.i_fundCluster  ?? '').toLowerCase().includes(fundCluster))  &&
            (!propertyType || (item.i_propertyType ?? '').toLowerCase().includes(propertyType))
        );
    });

    renderItems(filtered);
}

function bindFilters() {
    const ids = [
        'filterArticle',
        'filterPropertyNo',
        'filterSerialNo',
        'filterIcsNo',
        'filterFundCluster',
        'filterPropertyType'
    ];
    ids.forEach(id => {
        document.getElementById(id).addEventListener('input', applyFilters);
    });
}

// ─── RENDER ITEMS ────────────────────────────────────────────────────────────

function renderItems(items) {
    const tbody = document.getElementById('itemsTableBody');
    tbody.innerHTML = '';

    if (items.length === 0) {
        tbody.innerHTML = `<tr><td colspan="22" class="text-center text-muted py-3">No items found.</td></tr>`;
        return;
    }

    items.forEach(item => {
        const row = `
            <tr>
                <td class="iatao-article-col">${item.i_item ?? ''}</td>
                <td class="iatao-desc-col">${item.i_description ?? ''}</td>
                <td class="iatao-center-col">${item.i_propertyNo ?? ''}</td>
                <td class="iatao-center-col">${item.i_serialNo ?? ''}</td>
                <td class="iatao-center-col">${item.i_icsNo ?? ''}</td>
                <td class="iatao-center-col">${item.i_propertyType ?? ''}</td>
                <td class="iatao-center-col">${item.i_fundCluster ?? ''}</td>
                <td class="iatao-center-col">${item.i_uMeasurement ?? ''}</td>
                <td class="iatao-right-col">${item.i_uValue ?? ''}</td>
                <td class="iatao-center-col">${item.i_propertyCardNo ?? ''}</td>
                <td class="iatao-center-col">${item.i_physicalCountNo ?? ''}</td>
                <td class="iatao-center-col">${item.i_SOQuantity ?? ''}</td>
                <td class="iatao-right-col">${item.i_SOValue ?? ''}</td>
                <td class="iatao-center-col">${item.i_dateReceived ?? ''}</td>
                <td class="iatao-center-col">${item.i_issuedBy ?? ''}</td>
                <td class="iatao-center-col">${item.i_issuedTo ?? ''}</td>
                <td class="iatao-center-col">${item.i_dateIssued ?? ''}</td>
                <td class="iatao-center-col">${item.i_transaferedTo ?? ''}</td>
                <td class="iatao-center-col">${item.i_dateTransferred ?? ''}</td>
                <td class="iatao-center-col">${item.i_status ?? ''}</td>
                <td class="iatao-remarks-col">${item.i_notes ?? ''}</td>
                <td class="iatao-center-col">
                    <button class="btn btn-light btn-sm" onclick="editItem(${item.i_id})">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-light btn-sm" onclick="deleteItem(${item.i_id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>`;
        tbody.insertAdjacentHTML('beforeend', row);
    });
}

// ─── ADD ITEM ────────────────────────────────────────────────────────────────

document.getElementById('saveItemBtn').addEventListener('click', function () {
    const form      = document.getElementById('addItemForm');
    const alertBox  = document.getElementById('addItemAlert');
    const spinner   = document.getElementById('saveItemSpinner');
    const saveBtn   = this;

    alertBox.className = 'alert d-none';
    alertBox.textContent = '';

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const formData = new FormData(form);

    saveBtn.disabled = true;
    spinner.classList.remove('d-none');

    fetch('api/add-item.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('addItemModal'));
            modal.hide();
            form.reset();
            loadItems();
        } else {
            alertBox.className = 'alert alert-danger';
            alertBox.textContent = data.message;
        }
    })
    .catch(error => {
        console.error('Add Item Error:', error);
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'An unexpected error occurred. Please try again.';
    })
    .finally(() => {
        saveBtn.disabled = false;
        spinner.classList.add('d-none');
    });
});

// ─── EDIT ITEM ───────────────────────────────────────────────────────────────

function editItem(id) {
    const alertBox = document.getElementById('editItemAlert');
    alertBox.className = 'alert d-none';
    alertBox.textContent = '';

    fetch(`api/fetch-item.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert(data.message);
                return;
            }

            const item = data.data;

            document.getElementById('e_id').value               = item.i_id            ?? '';
            document.getElementById('e_propertyNo').value       = item.i_propertyNo    ?? '';
            document.getElementById('e_serialNo').value         = item.i_serialNo      ?? '';
            document.getElementById('e_icsNo').value            = item.i_icsNo         ?? '';
            document.getElementById('e_propertyType').value     = item.i_propertyType  ?? '';
            document.getElementById('e_fundCluster').value      = item.i_fundCluster   ?? '';
            document.getElementById('e_item').value             = item.i_item          ?? '';
            document.getElementById('e_description').value      = item.i_description   ?? '';
            document.getElementById('e_uMeasurement').value     = item.i_uMeasurement  ?? '';
            document.getElementById('e_uValue').value           = item.i_uValue        ?? '';
            document.getElementById('e_propertyCardNo').value   = item.i_propertyCardNo  ?? '';
            document.getElementById('e_physicalCountNo').value  = item.i_physicalCountNo ?? '';
            document.getElementById('e_SOQuantity').value       = item.i_SOQuantity    ?? '';
            document.getElementById('e_SOValue').value          = item.i_SOValue       ?? '';
            document.getElementById('e_dateReceived').value     = item.i_dateReceived  ?? '';
            document.getElementById('e_issuedBy').value         = item.i_issuedBy      ?? '';
            document.getElementById('e_issuedTo').value         = item.i_issuedTo      ?? '';
            document.getElementById('e_dateIssued').value       = item.i_dateIssued    ?? '';
            document.getElementById('e_transferredTo').value    = item.i_transaferedTo ?? '';
            document.getElementById('e_dateTransferred').value  = item.i_dateTransferred ?? '';
            document.getElementById('e_status').value           = item.i_status        ?? '';
            document.getElementById('e_notes').value            = item.i_notes         ?? '';

            const modal = new bootstrap.Modal(document.getElementById('editItemModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Edit Item Fetch Error:', error);
            alert('Failed to load item details.');
        });
}

document.getElementById('updateItemBtn').addEventListener('click', function () {
    const form      = document.getElementById('editItemForm');
    const alertBox  = document.getElementById('editItemAlert');
    const spinner   = document.getElementById('updateItemSpinner');
    const updateBtn = this;

    alertBox.className = 'alert d-none';
    alertBox.textContent = '';

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const formData = new FormData(form);

    updateBtn.disabled = true;
    spinner.classList.remove('d-none');

    fetch('api/edit-item.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('editItemModal'));
            modal.hide();
            form.reset();
            loadItems();
        } else {
            alertBox.className = 'alert alert-danger';
            alertBox.textContent = data.message;
        }
    })
    .catch(error => {
        console.error('Update Item Error:', error);
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'An unexpected error occurred. Please try again.';
    })
    .finally(() => {
        updateBtn.disabled = false;
        spinner.classList.add('d-none');
    });
});

function deleteItem(id) {
    console.log('Delete item:', id);
}

// ─── INIT ────────────────────────────────────────────────────────────────────

document.addEventListener('DOMContentLoaded', () => {
    bindFilters();
    loadItems();
});
</script>