<?php
require_once '../../global-library/database.php';

header('Content-Type: application/json');

try {

    $id = trim($_GET['id'] ?? '');

    // ─── SINGLE ITEM (for edit modal) ─────────────────────────────────────────
    if (!empty($id)) {

        if (!is_numeric($id)) {
            throw new Exception("Invalid item ID.");
        }

        $stmt = $conn->prepare("
            SELECT
                si_id,
                s_id,
                si_propertyNo,
                si_serialNo,
                si_icsNo,
                si_item,
                si_description,
                si_uMeasurement,
                si_uValue,
                si_propertyCardNo,
                si_physicalCountNo,
                si_SOQuantity,
                si_SOValue,
                si_issuedBy,
                si_dateIssued,
                si_status,
                si_notes,
                si_propertyType,
                si_fundCluster,
                si_dateReceived
            FROM tbl_schoolitems
            WHERE si_id = ? AND is_deleted = 0
            LIMIT 1
        ");

        $stmt->execute([(int)$id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$item) {
            throw new Exception("Item not found.");
        }

        echo json_encode([
            "success" => true,
            "message" => "Item fetched successfully.",
            "data"    => $item
        ]);

    // ─── ALL ITEMS (for table) ────────────────────────────────────────────────
    } else {

        $stmt = $conn->prepare("
            SELECT
                si_id,
                s_id,
                si_propertyNo,
                si_serialNo,
                si_icsNo,
                si_item,
                si_description,
                si_uMeasurement,
                si_uValue,
                si_propertyCardNo,
                si_physicalCountNo,
                si_SOQuantity,
                si_SOValue,
                si_issuedBy,
                si_dateIssued,
                si_status,
                si_notes,
                si_propertyType,
                si_fundCluster,
                si_dateReceived
            FROM tbl_schoolitems
            WHERE is_deleted = 0
            ORDER BY si_id DESC
        ");

        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "success" => true,
            "message" => "School items fetched successfully.",
            "data"    => $items
        ]);
    }

} catch (Exception $e) {

    error_log("Fetch School Items Error: " . $e->getMessage());

    echo json_encode([
        "success" => false,
        "message" => "Failed to fetch school item(s). Error: " . $e->getMessage()
    ]);
}

?>