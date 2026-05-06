<style>
    .form-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 40px;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    h2 {
        text-align: center;
        margin-bottom: 40px;
        color: #1e293b;
        font-weight: 700;
        font-size: 28px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #475569;
        font-size: 14px;
        letter-spacing: 0.3px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 14px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 15px;
        font-family: inherit;
        box-sizing: border-box;
        transition: all 0.3s ease;
        background-color: #f8fafc;
        color: #334155;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #3b82f6;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .form-row-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 24px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 14px 32px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        width: 100%;
        margin-top: 10px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
    }

    .alert {
        padding: 16px 20px;
        margin-bottom: 24px;
        border-radius: 10px;
        font-weight: 500;
    }

    .alert-success {
        background-color: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }

    .alert-error {
        background-color: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    
    @media (max-width: 768px) {
        .form-row, .form-row-3 {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
</style>

<section class="content-section" id="content">
    <div class="form-container">
        <h2><i class="fas fa-plus-circle"></i> Add School Item</h2>
        
        <div id="alertMessage"></div>

        <form id="schoolItemForm" enctype="multipart/form-data">
            
            <!-- Property Information Section -->
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

            <!-- Item Details Section -->
            <div class="form-group">
                <label for="item">Item Name *</label>
                <input type="text" id="item" name="item" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description"></textarea>
            </div>

            <!-- Measurement & Value Section -->
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

            <!-- Property Card & Physical Count Section -->
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

            <!-- Stock & Value Section -->
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

            <!-- Date & Status Section -->
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

            <!-- Classification Section -->
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

            <!-- Notes Section -->
            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" placeholder="Additional notes or remarks..."></textarea>
            </div>

            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Submit</button>
        </form>
    </div>
</section>

<script>
document.getElementById('schoolItemForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const alertDiv = document.getElementById('alertMessage');

    try {
        const response = await fetch('<?php echo WEB_ROOT; ?>school-item/api/add.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (response.ok && data.success) {
            alertDiv.innerHTML = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> School item added successfully!</div>';
            document.getElementById('schoolItemForm').reset();
            setTimeout(() => {
                alertDiv.innerHTML = '';
            }, 5000);
        } else {
            alertDiv.innerHTML = '<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> ' + (data.message || 'Error adding school item') + '</div>';
        }
    } catch (error) {
        alertDiv.innerHTML = '<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> Error: ' + error.message + '</div>';
    }
});
</script>