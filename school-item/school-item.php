<link rel="stylesheet" href="<?php echo WEB_ROOT; ?>school-item/css/school-item.css">

<section class="content-section" id="content">
    <h2><i class="fas fa-plus-circle"></i> School Items</h2>
    <div id="alertMessage"></div>

    <!-- Table -->
    <div class="table-container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="fas fa-list"></i> School Items</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fas fa-plus"></i> Add Item
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle" id="schoolItemsTable">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Item Name</th>
                        <th>Description</th>
                        <th>Property No.</th>
                        <th>Serial No.</th>
                        <th>ICS No.</th>
                        <th>Property Type</th>
                        <th>Fund Cluster</th>
                        <th>Unit of Measure</th>
                        <th>Unit Value</th>
                        <th>Property Card No.</th>
                        <th>Physical Count No.</th>
                        <th>Shortage/Overage Quantity</th>
                        <th>Shortage/Overage Value</th>
                        <th>Issued By</th>
                        <th>Date Issued</th>
                        <th>Date Received</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="schoolItemsTableBody">
                    <tr>
                        <td colspan="20" class="text-center text-muted py-3">Loading items...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>


<!-- ─── ADD ITEM MODAL ──────────────────────────────────────────────────────── -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addItemModalLabel">Add School Item</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="addItemAlert" class="alert d-none" role="alert"></div>
                <form id="schoolItemForm">

                    <div class="form-row-3">
                        <div class="form-group">
                            <label for="propertyNo">Property Number *</label>
                            <input type="text" id="propertyNo" name="propertyNo" required>
                        </div>
                        <div class="form-group">
                            <label for="serialNo">Serial Number</label>
                            <input type="text" id="serialNo" name="serialNo">
                        </div>
                        <div class="form-group">
                            <label for="icsNo">ICS Number</label>
                            <input type="text" id="icsNo" name="icsNo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="item">Item Name *</label>
                        <input type="text" id="item" name="item" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="uMeasurement">Unit of Measurement</label>
                            <input type="text" id="uMeasurement" name="uMeasurement" placeholder="e.g., piece, set, box">
                        </div>
                        <div class="form-group">
                            <label for="uValue">Unit Value</label>
                            <input type="number" id="uValue" name="uValue" step="0.01">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="propertyCardNo">Property Card Number</label>
                            <input type="number" id="propertyCardNo" name="propertyCardNo">
                        </div>
                        <div class="form-group">
                            <label for="physicalCountNo">Physical Count Number</label>
                            <input type="number" id="physicalCountNo" name="physicalCountNo">
                        </div>
                    </div>

                    <div class="form-row-3">
                        <div class="form-group">
                            <label for="SOQuantity">SO Quantity</label>
                            <input type="number" id="SOQuantity" name="SOQuantity">
                        </div>
                        <div class="form-group">
                            <label for="SOValue">SO Value</label>
                            <input type="number" id="SOValue" name="SOValue" step="0.01">
                        </div>
                        <div class="form-group">
                            <label for="issuedBy">Issued By</label>
                            <input type="text" id="issuedBy" name="issuedBy">
                        </div>
                    </div>

                    <div class="form-row-3">
                        <div class="form-group">
                            <label for="dateIssued">Date Issued</label>
                            <input type="date" id="dateIssued" name="dateIssued">
                        </div>
                        <div class="form-group">
                            <label for="dateReceived">Date Received</label>
                            <input type="date" id="dateReceived" name="dateReceived">
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status">
                                <option value="">Select Status</option>
                                <option value="Serviceable">Serviceable</option>
                                <option value="Transferred">Transferred</option>
                                <option value="Stolen">Stolen</option>
                                <option value="Lost">Lost</option>
                                <option value="Damaged due to calamity">Damaged due to calamity</option>
                                <option value="For disposal">For disposal</option>
                                <option value="Disposed">Disposed</option>
                                <option value="Donated">Donated</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="propertyType">Property Type</label>
                            <select id="propertyType" name="propertyType">
                                <option value="">Select Property Type</option>
                                <option value="Furniture">Furniture</option>
                                <option value="Equipment">Equipment</option>
                                <option value="Technology">Technology</option>
                                <option value="Books">Books</option>
                                <option value="Supplies">Supplies</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fundCluster">Fund Cluster</label>
                            <input type="text" id="fundCluster" name="fundCluster" placeholder="e.g., GAA, Special Fund">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea id="notes" name="notes" placeholder="Additional notes or remarks..."></textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveSchoolItemBtn">
                    <span id="saveSchoolItemSpinner" class="spinner-border spinner-border-sm d-none me-1" role="status"></span>
                    Save Item
                </button>
            </div>
        </div>
    </div>
</div>


<!-- ─── EDIT ITEM MODAL ─────────────────────────────────────────────────────── -->
<div class="modal fade" id="editSchoolItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editItemModalLabel">Edit School Item</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="editItemAlert" class="alert d-none" role="alert"></div>
                <form id="editSchoolItemForm">
                    <input type="hidden" id="e_si_id" name="e_si_id">

                    <div class="form-row-3">
                        <div class="form-group">
                            <label for="e_propertyNo">Property Number *</label>
                            <input type="text" id="e_propertyNo" name="e_propertyNo" required>
                        </div>
                        <div class="form-group">
                            <label for="e_serialNo">Serial Number</label>
                            <input type="text" id="e_serialNo" name="e_serialNo">
                        </div>
                        <div class="form-group">
                            <label for="e_icsNo">ICS Number</label>
                            <input type="text" id="e_icsNo" name="e_icsNo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="e_item">Item Name *</label>
                        <input type="text" id="e_item" name="e_item" required>
                    </div>

                    <div class="form-group">
                        <label for="e_description">Description</label>
                        <textarea id="e_description" name="e_description"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="e_uMeasurement">Unit of Measurement</label>
                            <input type="text" id="e_uMeasurement" name="e_uMeasurement" placeholder="e.g., piece, set, box">
                        </div>
                        <div class="form-group">
                            <label for="e_uValue">Unit Value</label>
                            <input type="number" id="e_uValue" name="e_uValue" step="0.01">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="e_propertyCardNo">Property Card Number</label>
                            <input type="number" id="e_propertyCardNo" name="e_propertyCardNo">
                        </div>
                        <div class="form-group">
                            <label for="e_physicalCountNo">Physical Count Number</label>
                            <input type="number" id="e_physicalCountNo" name="e_physicalCountNo">
                        </div>
                    </div>

                    <div class="form-row-3">
                        <div class="form-group">
                            <label for="e_SOQuantity">SO Quantity</label>
                            <input type="number" id="e_SOQuantity" name="e_SOQuantity">
                        </div>
                        <div class="form-group">
                            <label for="e_SOValue">SO Value</label>
                            <input type="number" id="e_SOValue" name="e_SOValue" step="0.01">
                        </div>
                        <div class="form-group">
                            <label for="e_issuedBy">Issued By</label>
                            <input type="text" id="e_issuedBy" name="e_issuedBy">
                        </div>
                    </div>

                    <div class="form-row-3">
                        <div class="form-group">
                            <label for="e_dateIssued">Date Issued</label>
                            <input type="date" id="e_dateIssued" name="e_dateIssued">
                        </div>
                        <div class="form-group">
                            <label for="e_dateReceived">Date Received</label>
                            <input type="date" id="e_dateReceived" name="e_dateReceived">
                        </div>
                        <div class="form-group">
                            <label for="e_status">Status</label>
                            <select id="e_status" name="e_status">
                                <option value="">Select Status</option>
                                <option value="Serviceable">Serviceable</option>
                                <option value="Transferred">Transferred</option>
                                <option value="Stolen">Stolen</option>
                                <option value="Lost">Lost</option>
                                <option value="Damaged due to calamity">Damaged due to calamity</option>
                                <option value="For disposal">For disposal</option>
                                <option value="Disposed">Disposed</option>
                                <option value="Donated">Donated</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="e_propertyType">Property Type</label>
                            <select id="e_propertyType" name="e_propertyType">
                                <option value="">Select Property Type</option>
                                <option value="Furniture">Furniture</option>
                                <option value="Equipment">Equipment</option>
                                <option value="Technology">Technology</option>
                                <option value="Books">Books</option>
                                <option value="Supplies">Supplies</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="e_fundCluster">Fund Cluster</label>
                            <input type="text" id="e_fundCluster" name="e_fundCluster" placeholder="e.g., GAA, Special Fund">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="e_notes">Notes</label>
                        <textarea id="e_notes" name="e_notes" placeholder="Additional notes or remarks..."></textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateSchoolItemBtn">
                    <span id="updateSchoolItemSpinner" class="spinner-border spinner-border-sm d-none me-1" role="status"></span>
                    Update Item
                </button>
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
    return `<span class="badge bg-${color}">${status ?? '—'}</span>`;
}

// ─── LOAD & RENDER ────────────────────────────────────────────────────────────

function loadSchoolItems() {
    const tbody = document.getElementById('schoolItemsTableBody');
    tbody.innerHTML = `<tr><td colspan="20" class="text-center text-muted py-3">Loading items...</td></tr>`;

    fetch('<?php echo WEB_ROOT; ?>school-item/api/fetch-school-items.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderSchoolItems(data.data);
            } else {
                tbody.innerHTML = `<tr><td colspan="20" class="text-center text-danger py-3">${data.message}</td></tr>`;
            }
        })
        .catch(error => {
            console.error('Fetch School Items Error:', error);
            tbody.innerHTML = `<tr><td colspan="20" class="text-center text-danger py-3">Failed to load items.</td></tr>`;
        });
}

function renderSchoolItems(items) {
    const tbody = document.getElementById('schoolItemsTableBody');
    tbody.innerHTML = '';

    if (items.length === 0) {
        tbody.innerHTML = `<tr><td colspan="20" class="text-center text-muted py-3">No items found.</td></tr>`;
        return;
    }

    items.forEach((item, index) => {
        const row = `
            <tr>
                <td>${index + 1}</td>
                <td>${item.si_item ?? '—'}</td>
                <td>${item.si_description ?? '—'}</td>
                <td>${item.si_propertyNo ?? '—'}</td>
                <td>${item.si_serialNo ?? '—'}</td>
                <td>${item.si_icsNo ?? '—'}</td>
                <td>${item.si_propertyType ?? '—'}</td>
                <td>${item.si_fundCluster ?? '—'}</td>
                <td>${item.si_uMeasurement ?? '—'}</td>
                <td>${item.si_uValue ?? '—'}</td>
                <td>${item.si_propertyCardNo ?? '—'}</td>
                <td>${item.si_physicalCountNo ?? '—'}</td>
                <td>${item.si_SOQuantity ?? '—'}</td>
                <td>${item.si_SOValue ?? '—'}</td>
                <td>${item.si_issuedBy ?? '—'}</td>
                <td>${item.si_dateIssued ?? '—'}</td>
                <td>${item.si_dateReceived ?? '—'}</td>
                <td>${getStatusBadge(item.si_status)}</td>
                <td>${item.si_notes ?? '—'}</td>
                <td>
                    <button class="btn btn-light btn-sm" onclick="editSchoolItem(${item.si_id})">
                       <i class="bi bi-pencil-square">Edit</i>
                    </button>
                </td>
            </tr>`;
        tbody.insertAdjacentHTML('beforeend', row);
    });
}

// ─── ADD ITEM ─────────────────────────────────────────────────────────────────

document.getElementById('saveSchoolItemBtn').addEventListener('click', function () {
    const form     = document.getElementById('schoolItemForm');
    const alertBox = document.getElementById('addItemAlert');
    const spinner  = document.getElementById('saveSchoolItemSpinner');
    const saveBtn  = this;

    alertBox.className = 'alert d-none';
    alertBox.textContent = '';

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const formData = new FormData(form);

    saveBtn.disabled = true;
    spinner.classList.remove('d-none');

    fetch('<?php echo WEB_ROOT; ?>school-item/api/add.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('exampleModal')).hide();
            form.reset();
            loadSchoolItems();
        } else {
            alertBox.className = 'alert alert-danger';
            alertBox.textContent = data.message;
        }
    })
    .catch(error => {
        console.error('Add School Item Error:', error);
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'An unexpected error occurred. Please try again.';
    })
    .finally(() => {
        saveBtn.disabled = false;
        spinner.classList.add('d-none');
    });
});

// ─── EDIT ITEM ────────────────────────────────────────────────────────────────

function editSchoolItem(id) {
    const alertBox = document.getElementById('editItemAlert');
    alertBox.className = 'alert d-none';
    alertBox.textContent = '';

    fetch(`<?php echo WEB_ROOT; ?>school-item/api/fetch-school-items.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert(data.message);
                return;
            }

            const item = data.data;

            document.getElementById('e_si_id').value          = item.si_id              ?? '';
            document.getElementById('e_propertyNo').value     = item.si_propertyNo      ?? '';
            document.getElementById('e_serialNo').value       = item.si_serialNo        ?? '';
            document.getElementById('e_icsNo').value          = item.si_icsNo           ?? '';
            document.getElementById('e_item').value           = item.si_item            ?? '';
            document.getElementById('e_description').value    = item.si_description     ?? '';
            document.getElementById('e_uMeasurement').value   = item.si_uMeasurement    ?? '';
            document.getElementById('e_uValue').value         = item.si_uValue          ?? '';
            document.getElementById('e_propertyCardNo').value = item.si_propertyCardNo  ?? '';
            document.getElementById('e_physicalCountNo').value= item.si_physicalCountNo ?? '';
            document.getElementById('e_SOQuantity').value     = item.si_SOQuantity      ?? '';
            document.getElementById('e_SOValue').value        = item.si_SOValue         ?? '';
            document.getElementById('e_issuedBy').value       = item.si_issuedBy        ?? '';
            document.getElementById('e_dateIssued').value     = item.si_dateIssued      ?? '';
            document.getElementById('e_dateReceived').value   = item.si_dateReceived    ?? '';
            document.getElementById('e_status').value         = item.si_status          ?? '';
            document.getElementById('e_propertyType').value   = item.si_propertyType    ?? '';
            document.getElementById('e_fundCluster').value    = item.si_fundCluster     ?? '';
            document.getElementById('e_notes').value          = item.si_notes           ?? '';

            new bootstrap.Modal(document.getElementById('editSchoolItemModal')).show();
        })
        .catch(error => {
            console.error('Edit Fetch Error:', error);
            alert('Failed to load item details.');
        });
}

document.getElementById('updateSchoolItemBtn').addEventListener('click', function () {
    const form      = document.getElementById('editSchoolItemForm');
    const alertBox  = document.getElementById('editItemAlert');
    const spinner   = document.getElementById('updateSchoolItemSpinner');
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

    fetch('<?php echo WEB_ROOT; ?>school-item/api/edit-school-item.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('editSchoolItemModal')).hide();
            form.reset();
            loadSchoolItems();
        } else {
            alertBox.className = 'alert alert-danger';
            alertBox.textContent = data.message;
        }
    })
    .catch(error => {
        console.error('Update School Item Error:', error);
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'An unexpected error occurred. Please try again.';
    })
    .finally(() => {
        updateBtn.disabled = false;
        spinner.classList.add('d-none');
    });
});

// ─── INIT ─────────────────────────────────────────────────────────────────────

document.addEventListener('DOMContentLoaded', loadSchoolItems);

</script>