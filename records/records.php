<?php
if (!isset($_SESSION['school_id'])) {
    header("Location: " . WEB_ROOT . "login");
    exit();
}

$school_id = $_SESSION['school_id'];
$query = "SELECT * FROM tbl_schoolitems WHERE s_id = ? AND is_deleted = 0 ORDER BY si_id DESC";
$stmt = $conn->prepare($query);
$stmt->execute([$school_id]);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

function getStatusClass($status) {
    switch (strtolower(trim($status))) {
        case 'serviceable': return 'status-serviceable';
        case 'transferred': return 'status-transferred';
        case 'stolen': return 'status-stolen';
        case 'lost': return 'status-lost';
        case 'damaged due to calamity': return 'status-damaged';
        case 'for disposal': return 'status-disposal';
        case 'disposed': return 'status-disposed';
        case 'donated': return 'status-donated';
        default: return 'status-default';
    }
}
?>

<style>
    .records-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 40px;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #1e293b;
        font-weight: 700;
        font-size: 28px;
    }

    .records-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .search-container {
        position: relative;
        flex-grow: 1;
        max-width: 400px;
    }

    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .search-input {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 15px;
        font-family: inherit;
        background-color: #f8fafc;
        transition: all 0.3s ease;
        color: #334155;
    }

    .search-input:focus {
        outline: none;
        border-color: #3b82f6;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .record-count {
        background: #f1f5f9;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .record-count span {
        background: #3b82f6;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 14px 15px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 600;
        font-size: 14px;
        white-space: nowrap;
    }

    td {
        color: #334155;
        font-size: 14px;
        vertical-align: middle;
    }

    tbody tr {
        transition: background-color 0.2s;
    }
    
    tbody tr:hover {
        background-color: #f8fafc;
    }
    
    /* Status Pills */
    .status-pill {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }
    
    .status-serviceable { background: #dcfce7; color: #166534; }
    .status-transferred { background: #fef9c3; color: #854d0e; }
    .status-stolen { background: #fee2e2; color: #991b1b; }
    .status-lost { background: #fee2e2; color: #991b1b; }
    .status-damaged { background: #ffedd5; color: #9a3412; }
    .status-disposal { background: #f1f5f9; color: #475569; }
    .status-disposed { background: #e2e8f0; color: #334155; }
    .status-donated { background: #dbeafe; color: #1e40af; }
    .status-default { background: #f1f5f9; color: #475569; }

    .action-btn {
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s;
        margin-right: 5px;
    }

    .btn-edit {
        background-color: #e0f2fe;
        color: #0284c7;
    }

    .btn-edit:hover {
        background-color: #bae6fd;
    }

    .btn-delete {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .btn-delete:hover {
        background-color: #fecaca;
    }
    
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }
    
    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 30px;
        border-radius: 12px;
        width: 90%;
        max-width: 800px;
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }
    
    .close:hover {
        color: black;
    }

    /* Reuse some form styles from school-item for the modal */
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 14px; }
    .form-group input, .form-group select, .form-group textarea {
        width: 100%; padding: 12px; border: 1.5px solid #e2e8f0; border-radius: 8px;
        font-size: 14px; box-sizing: border-box; background-color: #f8fafc;
    }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .btn-submit {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white; padding: 12px 24px; border: none; border-radius: 8px;
        cursor: pointer; font-weight: 600; width: 100%;
    }
</style>

<section class="content-section" id="content">
    <div class="records-container">
        <h2><i class="fas fa-clipboard-list"></i> School Item Records</h2>
        
        <div id="alertMessage"></div>

        <div class="records-header">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" placeholder="Search by name, status, or type..." class="search-input">
            </div>
            <div class="record-count">
                Total Items: <span id="visibleCount"><?php echo count($records); ?></span>
            </div>
        </div>

        <div class="table-responsive">
            <table id="recordsTable">
                <thead>
                    <tr>
                        <th>Property No.</th>
                        <th>Item Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Date Received</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($records) > 0): ?>
                        <?php foreach ($records as $row): ?>
                            <tr class="record-row">
                                <td><?php echo htmlspecialchars($row['si_propertyNo']); ?></td>
                                <td><?php echo htmlspecialchars($row['si_item']); ?></td>
                                <td><?php echo htmlspecialchars($row['si_propertyType'] ?? 'N/A'); ?></td>
                                <td>
                                    <span class="status-pill <?php echo getStatusClass($row['si_status']); ?>">
                                        <?php echo htmlspecialchars($row['si_status']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($row['si_dateReceived']); ?></td>
                                <td><?php echo htmlspecialchars($row['si_SOQuantity']); ?></td>
                                <td>
                                    <button class="action-btn btn-edit" onclick='openEditModal(<?php echo json_encode($row); ?>)'><i class="fas fa-edit"></i> Edit</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr id="emptyStateRow">
                            <td colspan="7" style="text-align: center; padding: 30px; color: #64748b;">No records found. Submit items to see them here.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #1e293b;">Edit School Item</h3>
        
        <div id="modalAlertMessage"></div>

        <form id="editForm">
            <input type="hidden" id="edit_id" name="id">
            
            <div class="form-row">
                <div class="form-group">
                    <label>Property Number *</label>
                    <input type="text" id="edit_propertyNo" name="propertyNo" required>
                </div>
                <div class="form-group">
                    <label>Item Name *</label>
                    <input type="text" id="edit_item" name="item" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Serial Number</label>
                    <input type="text" id="edit_serialNo" name="serialNo">
                </div>
                <div class="form-group">
                    <label>ICS Number</label>
                    <input type="text" id="edit_icsNo" name="icsNo">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Status</label>
                    <select id="edit_status" name="status">
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
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" id="edit_SOQuantity" name="SOQuantity">
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea id="edit_description" name="description" rows="3"></textarea>
            </div>

            <button type="submit" class="btn-submit">Save Changes</button>
        </form>
    </div>
</div>

<script>
function openEditModal(data) {
    document.getElementById('edit_id').value = data.si_id;
    document.getElementById('edit_propertyNo').value = data.si_propertyNo;
    document.getElementById('edit_item').value = data.si_item;
    document.getElementById('edit_serialNo').value = data.si_serialNo;
    document.getElementById('edit_icsNo').value = data.si_icsNo;
    document.getElementById('edit_status').value = data.si_status;
    document.getElementById('edit_SOQuantity').value = data.si_SOQuantity;
    document.getElementById('edit_description').value = data.si_description;
    
    document.getElementById('editModal').style.display = "block";
}

function closeEditModal() {
    document.getElementById('editModal').style.display = "none";
}

window.onclick = function(event) {
    var modal = document.getElementById('editModal');
    if (event.target == modal) {
        closeEditModal();
    }
}

document.getElementById('editForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const alertDiv = document.getElementById('modalAlertMessage');

    try {
        const response = await fetch('<?php echo WEB_ROOT; ?>records/api/update.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (response.ok && data.success) {
            alert("Record updated successfully!");
            location.reload();
        } else {
            alertDiv.innerHTML = '<div style="color:red; margin-bottom:15px; padding:10px; background:#fee2e2; border-radius:6px;">' + (data.message || 'Error updating record') + '</div>';
        }
    } catch (error) {
        alertDiv.innerHTML = '<div style="color:red; margin-bottom:15px; padding:10px; background:#fee2e2; border-radius:6px;">Error: ' + error.message + '</div>';
    }
});


</script>

<script>
// Search and Filter Functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.record-row');
    let visibleCount = 0;

    rows.forEach(row => {
        // We get all the text content from the row
        const text = row.textContent.toLowerCase();
        
        if (text.includes(searchTerm)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    // Update the counter
    document.getElementById('visibleCount').textContent = visibleCount;
    
    // Handle empty state row dynamically
    let emptyRow = document.getElementById('searchEmptyRow');
    const tbody = document.querySelector('#recordsTable tbody');
    
    if (visibleCount === 0 && rows.length > 0) {
        if (!emptyRow) {
            emptyRow = document.createElement('tr');
            emptyRow.id = 'searchEmptyRow';
            emptyRow.innerHTML = '<td colspan="7" style="text-align: center; padding: 30px; color: #64748b;"><i class="fas fa-search" style="font-size: 24px; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>No matching items found.</td>';
            tbody.appendChild(emptyRow);
        } else {
            emptyRow.style.display = '';
        }
    } else if (emptyRow) {
        emptyRow.style.display = 'none';
    }
});
</script>
