<?php
require_once '../../../global-library/database.php';

header('Content-Type: application/json');

try {

    // ─── TOTAL ITEMS ──────────────────────────────────────────────────────────
    $totalItems = $conn->prepare("
        SELECT COUNT(*) AS total 
        FROM tbl_items 
        WHERE is_deleted = 0
    ");
    $totalItems->execute();
    $total = $totalItems->fetch(PDO::FETCH_ASSOC)['total'];

    // ─── ITEMS BY STATUS ──────────────────────────────────────────────────────
    $byStatus = $conn->prepare("
        SELECT 
            i_status, 
            COUNT(*) AS count 
        FROM tbl_items 
        WHERE is_deleted = 0 
        GROUP BY i_status
        ORDER BY count DESC
    ");
    $byStatus->execute();
    $statusData = $byStatus->fetchAll(PDO::FETCH_ASSOC);

    // ─── ITEMS BY PROPERTY TYPE ───────────────────────────────────────────────
    $byType = $conn->prepare("
        SELECT 
            COALESCE(NULLIF(TRIM(i_propertyType), ''), 'Unspecified') AS i_propertyType,
            COUNT(*) AS count 
        FROM tbl_items 
        WHERE is_deleted = 0 
        GROUP BY i_propertyType
        ORDER BY count DESC
    ");
    $byType->execute();
    $typeData = $byType->fetchAll(PDO::FETCH_ASSOC);

    // ─── ITEMS BY FUND CLUSTER ────────────────────────────────────────────────
    $byFund = $conn->prepare("
        SELECT 
            COALESCE(NULLIF(TRIM(i_fundCluster), ''), 'Unspecified') AS i_fundCluster,
            COUNT(*) AS count 
        FROM tbl_items 
        WHERE is_deleted = 0 
        GROUP BY i_fundCluster
        ORDER BY count DESC
    ");
    $byFund->execute();
    $fundData = $byFund->fetchAll(PDO::FETCH_ASSOC);

    // ─── TOTAL SCHOOLS ────────────────────────────────────────────────────────
    $totalSchools = $conn->prepare("
        SELECT COUNT(*) AS total 
        FROM tbl_schools 
        WHERE is_deleted = 0
    ");
    $totalSchools->execute();
    $schools = $totalSchools->fetch(PDO::FETCH_ASSOC)['total'];

    // ─── TOTAL SCHOOL ITEMS ───────────────────────────────────────────────────
    $totalSchoolItems = $conn->prepare("
        SELECT COUNT(*) AS total 
        FROM tbl_schoolitems 
        WHERE is_deleted = 0
    ");
    $totalSchoolItems->execute();
    $schoolItems = $totalSchoolItems->fetch(PDO::FETCH_ASSOC)['total'];

    // ─── RECENTLY ADDED ITEMS (last 5) ────────────────────────────────────────
    $recentItems = $conn->prepare("
        SELECT 
            i_id,
            i_item,
            i_propertyNo,
            i_propertyType,
            i_status,
            i_dateReceived
        FROM tbl_items
        WHERE is_deleted = 0
        ORDER BY i_id DESC
        LIMIT 5
    ");
    $recentItems->execute();
    $recent = $recentItems->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "data"    => [
            "total_items"        => (int)$total,
            "total_schools"      => (int)$schools,
            "total_school_items" => (int)$schoolItems,
            "by_status"          => $statusData,
            "by_property_type"   => $typeData,
            "by_fund_cluster"    => $fundData,
            "recent_items"       => $recent
        ]
    ]);

} catch (Exception $e) {

    error_log("Dashboard Error: " . $e->getMessage());

    echo json_encode([
        "success" => false,
        "message" => "Failed to load dashboard. Error: " . $e->getMessage()
    ]);
}

?>