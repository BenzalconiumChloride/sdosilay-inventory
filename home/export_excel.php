<?php
require_once '../global-library/database.php';

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

// Export Headers for Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Inventory_Analytics_Report_" . date('Y-m-d') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>School Inventory Analytics Report</h2>
    <p>Generated on: <?php echo date('Y-m-d H:i:s'); ?></p>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th colspan="2" style="background-color: #4f46e5; color: white;">Overall Metrics</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Inventory Items</td>
                <td><strong><?php echo $total_items; ?></strong></td>
            </tr>
            <tr>
                <td>Serviceable Items</td>
                <td><strong><?php echo $status_counts['Serviceable'] ?? 0; ?></strong></td>
            </tr>
            <tr>
                <td>Damaged / Needs Attention (Damaged, Lost, Stolen)</td>
                <td>
                    <strong>
                    <?php 
                    $attention_count = ($status_counts['Damaged due to calamity'] ?? 0) + ($status_counts['Lost'] ?? 0) + ($status_counts['Stolen'] ?? 0);
                    echo $attention_count; 
                    ?>
                    </strong>
                </td>
            </tr>
        </tbody>
    </table>

    <br><br>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th colspan="2" style="background-color: #3b82f6; color: white;">Items by Status</th>
            </tr>
            <tr>
                <th>Status</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $standard_statuses = ['Serviceable', 'Transferred', 'Lost', 'Stolen', 'Damaged due to calamity', 'For disposal', 'Disposed', 'Donated'];
            $all_statuses = array_unique(array_merge($standard_statuses, array_keys($status_counts)));
            foreach ($all_statuses as $status) {
                if (empty($status)) continue;
                $count = $status_counts[$status] ?? 0;
                echo "<tr><td>" . htmlspecialchars($status) . "</td><td>" . $count . "</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <br><br>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th colspan="2" style="background-color: #10b981; color: white;">Property Types Breakdown</th>
            </tr>
            <tr>
                <th>Property Type</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (empty($type_counts)) {
                echo "<tr><td colspan='2'>No data available.</td></tr>";
            } else {
                arsort($type_counts);
                foreach ($type_counts as $type => $count) {
                    if (empty($type)) $type = "Uncategorized";
                    echo "<tr><td>" . htmlspecialchars($type) . "</td><td>" . $count . "</td></tr>";
                }
            } 
            ?>
        </tbody>
    </table>
</body>
</html>
