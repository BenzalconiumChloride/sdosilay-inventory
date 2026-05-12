<?php
require_once '../../../global-library/database.php';

header('Content-Type: application/json');

try {

    $s_id = trim($_GET['s_id'] ?? '');

    if (empty($s_id) || !is_numeric($s_id)) {
        throw new Exception("Invalid or missing school ID.");
    }

    $stmt = $conn->prepare("
        SELECT
            si.si_id,
            si.si_propertyNo,
            si.si_serialNo,
            si.si_icsNo,
            si.si_item,
            si.si_description,
            si.si_uMeasurement,
            si.si_uValue,
            si.si_propertyCardNo,
            si.si_physicalCountNo,
            si.si_SOQuantity,
            si.si_SOValue,
            si.si_issuedBy,
            si.si_dateIssued,
            si.si_dateReceived,
            si.si_status,
            si.si_notes,
            si.si_propertyType,
            si.si_fundCluster
        FROM tbl_schoolitems si
        INNER JOIN tbl_schools s
            ON s.s_id = si.s_id
            AND s.is_deleted = 0
        WHERE si.s_id = ?
          AND si.is_deleted = 0
        ORDER BY si.si_id DESC
    ");

    $stmt->execute([(int)$s_id]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "message" => "School items fetched successfully.",
        "data"    => $items
    ]);

} catch (Exception $e) {

    error_log("Fetch School Items By School Error: " . $e->getMessage());

    echo json_encode([
        "success" => false,
        "message" => "Failed to fetch school items. Error: " . $e->getMessage()
    ]);
}

?>