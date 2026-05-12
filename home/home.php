<?php
// Initialize database connection if not already available
global $conn;

// Condition to check if logged in as school or global admin
$where_clause = "is_deleted = 0";
$params = [];

if (isset($_SESSION['school_id'])) {
    $where_clause .= " AND s_id = ?";
    $params[] = $_SESSION['school_id'];
}

// Total Items
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM tbl_schoolitems WHERE $where_clause");
$stmt->execute($params);
$total_items = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Items by Status
$stmt = $conn->prepare("SELECT si_status, COUNT(*) as count FROM tbl_schoolitems WHERE $where_clause GROUP BY si_status");
$stmt->execute($params);
$status_counts = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $status_counts[$row['si_status']] = $row['count'];
}

// Items by Property Type
$stmt = $conn->prepare("SELECT si_propertyType, COUNT(*) as count FROM tbl_schoolitems WHERE $where_clause GROUP BY si_propertyType");
$stmt->execute($params);
$type_counts = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $type_counts[$row['si_propertyType']] = $row['count'];
}

// Helper to get nice colors for status
function getDashboardStatusStyle($status) {
    switch (strtolower(trim($status))) {
        case 'serviceable': return ['bg' => '#dcfce7', 'color' => '#166534', 'icon' => 'bi-check-circle'];
        case 'transferred': return ['bg' => '#fef9c3', 'color' => '#854d0e', 'icon' => 'bi-arrow-left-right'];
        case 'stolen': return ['bg' => '#fee2e2', 'color' => '#991b1b', 'icon' => 'bi-incognito'];
        case 'lost': return ['bg' => '#fee2e2', 'color' => '#991b1b', 'icon' => 'bi-question-circle'];
        case 'damaged due to calamity': return ['bg' => '#ffedd5', 'color' => '#9a3412', 'icon' => 'bi-house-dash'];
        case 'for disposal': return ['bg' => '#f1f5f9', 'color' => '#475569', 'icon' => 'bi-trash'];
        case 'disposed': return ['bg' => '#e2e8f0', 'color' => '#334155', 'icon' => 'bi-trash3'];
        case 'donated': return ['bg' => '#dbeafe', 'color' => '#1e40af', 'icon' => 'bi-gift'];
        default: return ['bg' => '#f1f5f9', 'color' => '#475569', 'icon' => 'bi-info-circle'];
    }
}

// Define some standard statuses so they show up even if 0
$standard_statuses = ['Serviceable', 'Transferred', 'Lost', 'Stolen', 'Damaged due to calamity', 'For disposal', 'Disposed', 'Donated'];
?>
<style>
/* Dashboard Styles */
.dashboard-container {
    padding: 20px 0;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.dashboard-header h1 {
    font-size: 28px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.header-actions .btn-download {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: transform 0.2s, box-shadow 0.2s;
}

.header-actions .btn-download:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
}

/* Overview Cards */
.metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.metric-card {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #f1f5f9;
}

.metric-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
}

.metric-card .icon-wrapper {
    position: absolute;
    right: -10px;
    top: -10px;
    font-size: 80px;
    opacity: 0.04;
    color: #0f172a;
    transition: transform 0.3s ease;
}

.metric-card:hover .icon-wrapper {
    transform: scale(1.1) rotate(5deg);
}

.metric-title {
    color: #64748b;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.metric-value {
    font-size: 36px;
    font-weight: 800;
    color: #0f172a;
}

.metric-primary {
    background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
    color: white;
    border: none;
}
.metric-primary .metric-title, .metric-primary .metric-value {
    color: white;
}
.metric-primary .icon-wrapper {
    color: white;
    opacity: 0.1;
}

/* Two Column Layout */
.dashboard-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
}

@media (max-width: 1024px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
}

.card-panel {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    border: 1px solid #f1f5f9;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.card-title {
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Status Breakdown */
.status-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
}

.status-item {
    display: flex;
    align-items: center;
    padding: 16px;
    border-radius: 12px;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.status-item:hover {
    transform: scale(1.02);
    border-color: #e2e8f0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.status-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-right: 16px;
}

.status-info {
    flex-grow: 1;
}

.status-name {
    font-size: 14px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 4px;
}

.status-count {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
}

/* Item Type Breakdown */
.type-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.type-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.type-header {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    font-weight: 600;
}

.type-name { color: #334155; }
.type-count { color: #0f172a; font-weight: 700; }

.type-bar-bg {
    width: 100%;
    height: 8px;
    background: #f1f5f9;
    border-radius: 4px;
    overflow: hidden;
}

.type-bar-fill {
    height: 100%;
    border-radius: 4px;
    background: linear-gradient(90deg, #3b82f6, #60a5fa);
    transition: width 1s ease-out;
}
</style>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Overview</h1>
        <div class="header-actions">
            <a href="<?php echo WEB_ROOT; ?>home/export_excel.php" class="btn-download" style="text-decoration: none;">
                <i class="bi bi-file-earmark-excel"></i> Download Excel
            </a>
        </div>
    </div>

    <!-- High Level Metrics -->
    <div class="metrics-grid">
        <div class="metric-card metric-primary">
            <div class="icon-wrapper"><i class="bi bi-boxes"></i></div>
            <div class="metric-title">Total Inventory Items</div>
            <div class="metric-value"><?php echo number_format($total_items); ?></div>
        </div>
        <div class="metric-card">
            <div class="icon-wrapper"><i class="bi bi-check-circle"></i></div>
            <div class="metric-title">Serviceable Items</div>
            <div class="metric-value"><?php echo number_format($status_counts['Serviceable'] ?? 0); ?></div>
        </div>
        <div class="metric-card">
            <div class="icon-wrapper"><i class="bi bi-exclamation-triangle"></i></div>
            <div class="metric-title">Damaged / Needs Attention</div>
            <div class="metric-value">
                <?php 
                $attention_count = ($status_counts['Damaged due to calamity'] ?? 0) + ($status_counts['Lost'] ?? 0) + ($status_counts['Stolen'] ?? 0);
                echo number_format($attention_count); 
                ?>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Status Breakdown -->
        <div class="card-panel">
            <div class="card-header">
                <div class="card-title">
                    <i class="bi bi-pie-chart" style="color:#3b82f6;"></i>
                    Items by Status
                </div>
            </div>
            
            <div class="status-list">
                <?php 
                // Merge database counts with standard statuses
                $all_statuses = array_unique(array_merge($standard_statuses, array_keys($status_counts)));
                foreach ($all_statuses as $status) {
                    if (empty($status)) continue;
                    $count = $status_counts[$status] ?? 0;
                    $style = getDashboardStatusStyle($status);
                ?>
                <div class="status-item" style="background-color: <?php echo $style['bg']; ?>33;">
                    <div class="status-icon" style="background-color: <?php echo $style['bg']; ?>; color: <?php echo $style['color']; ?>;">
                        <i class="bi <?php echo $style['icon']; ?>"></i>
                    </div>
                    <div class="status-info">
                        <div class="status-name"><?php echo htmlspecialchars($status); ?></div>
                        <div class="status-count"><?php echo number_format($count); ?></div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>

        <!-- Property Type Breakdown -->
        <div class="card-panel">
            <div class="card-header">
                <div class="card-title">
                    <i class="bi bi-tags" style="color:#10b981;"></i>
                    Property Types
                </div>
            </div>

            <div class="type-list">
                <?php 
                if (empty($type_counts)) {
                    echo "<p style='color:#64748b; text-align:center;'>No data available.</p>";
                } else {
                    // Sort descending by count
                    arsort($type_counts);
                    foreach ($type_counts as $type => $count) {
                        if (empty($type)) $type = "Uncategorized";
                        $percentage = $total_items > 0 ? ($count / $total_items) * 100 : 0;
                        
                        // Randomize slightly the colors or use a fixed gradient
                        $bar_gradient = "linear-gradient(90deg, #3b82f6, #60a5fa)";
                        if ($type == 'Equipment') $bar_gradient = "linear-gradient(90deg, #10b981, #34d399)";
                        if ($type == 'Furniture') $bar_gradient = "linear-gradient(90deg, #f59e0b, #fbbf24)";
                        if ($type == 'Technology') $bar_gradient = "linear-gradient(90deg, #8b5cf6, #a78bfa)";
                ?>
                <div class="type-item">
                    <div class="type-header">
                        <span class="type-name"><?php echo htmlspecialchars($type); ?></span>
                        <span class="type-count"><?php echo number_format($count); ?></span>
                    </div>
                    <div class="type-bar-bg">
                        <div class="type-bar-fill" style="width: <?php echo $percentage; ?>%; background: <?php echo $bar_gradient; ?>;"></div>
                    </div>
                </div>
                <?php 
                    }
                } 
                ?>
            </div>
        </div>
    </div>
</div></main>

      
