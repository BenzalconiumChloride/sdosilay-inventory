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

<script>

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
                    <a class="btn btn-primary btn-sm"
                        href="index.php?view=school-items&s_id=${school.s_id}&name=${encodeURIComponent(school.s_schoolName)}">
                        <i class="bi bi-eye"></i> View Items
                    </a>
                </td>
            </tr>`;
        tbody.insertAdjacentHTML('beforeend', row);
    });
}

// ─── INIT ─────────────────────────────────────────────────────────────────────

document.addEventListener('DOMContentLoaded', loadSchools);

</script>