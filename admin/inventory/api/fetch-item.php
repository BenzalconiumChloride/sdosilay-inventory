<?php
require_once '../../../global-library/database.php';

header('Content-Type: application/json');

try {

    $id = trim($_GET['id'] ?? '');

    // ─── SINGLE ITEM (for edit modal) ────────────────────────────────────────
    if (!empty($id)) {

        if (!is_numeric($id)) {
            throw new Exception("Invalid item ID.");
        }

        $stmt = $conn->prepare("
            SELECT
                i_id,
                i_propertyNo,
                i_serialNo,
                i_icsNo,
                i_propertyType,
                i_fundCluster,
                i_item,
                i_description,
                i_uMeasurement,
                i_uValue,
                i_propertyCardNo,
                i_physicalCountNo,
                i_SOQuantity,
                i_SOValue,
                i_dateReceived,
                i_issuedBy,
                i_issuedTo,
                i_dateIssued,
                i_transaferedTo,
                i_dateTransferred,
                i_status,
                i_notes
            FROM tbl_items
            WHERE i_id = ? AND is_deleted = 0
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
                i_id,
                i_propertyNo,
                i_serialNo,
                i_icsNo,
                i_propertyType,
                i_fundCluster,
                i_item,
                i_description,
                i_uMeasurement,
                i_uValue,
                i_propertyCardNo,
                i_physicalCountNo,
                i_SOQuantity,
                i_SOValue,
                i_dateReceived,
                i_issuedBy,
                i_issuedTo,
                i_dateIssued,
                i_transaferedTo,
                i_dateTransferred,
                i_status,
                i_notes
            FROM tbl_items
            WHERE is_deleted = 0
            ORDER BY i_id DESC
        ");

        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "success" => true,
            "message" => "Items fetched successfully.",
            "data"    => $items
        ]);

    }

} catch (Exception $e) {

    error_log("Fetch Item Error: " . $e->getMessage());

    echo json_encode([
        "success" => false,
        "message" => "Failed to fetch item(s). Error: " . $e->getMessage()
    ]);
}

?>