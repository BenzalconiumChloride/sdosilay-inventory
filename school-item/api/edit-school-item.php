<?php
require_once '../../global-library/database.php';

header('Content-Type: application/json');

try {

    $e_si_id          = trim($_POST['e_si_id']          ?? '');
    $e_propertyNo     = trim($_POST['e_propertyNo']     ?? '');
    $e_serialNo       = trim($_POST['e_serialNo']       ?? '');
    $e_icsNo          = trim($_POST['e_icsNo']          ?? '');
    $e_item           = trim($_POST['e_item']           ?? '');
    $e_description    = trim($_POST['e_description']    ?? '');
    $e_uMeasurement   = trim($_POST['e_uMeasurement']   ?? '');
    $e_uValue         = trim($_POST['e_uValue']         ?? '');
    $e_propertyCardNo = trim($_POST['e_propertyCardNo'] ?? '');
    $e_physicalCountNo= trim($_POST['e_physicalCountNo']?? '');
    $e_SOQuantity     = trim($_POST['e_SOQuantity']     ?? '');
    $e_SOValue        = trim($_POST['e_SOValue']        ?? '');
    $e_issuedBy       = trim($_POST['e_issuedBy']       ?? '');
    $e_dateIssued     = trim($_POST['e_dateIssued']     ?? '');
    $e_dateReceived   = trim($_POST['e_dateReceived']   ?? '');
    $e_status         = trim($_POST['e_status']         ?? '');
    $e_propertyType   = trim($_POST['e_propertyType']   ?? '');
    $e_fundCluster    = trim($_POST['e_fundCluster']    ?? '');
    $e_notes          = trim($_POST['e_notes']          ?? '');

    if (empty($e_si_id) || !is_numeric($e_si_id)) {
        throw new Exception("Invalid or missing item ID.");
    }

    if (empty($e_propertyNo) || empty($e_item)) {
        throw new Exception("Property Number and Item Name are required.");
    }

    $updateItem = $conn->prepare("
        UPDATE tbl_schoolitems SET
            si_propertyNo      = ?,
            si_serialNo        = ?,
            si_icsNo           = ?,
            si_item            = ?,
            si_description     = ?,
            si_uMeasurement    = ?,
            si_uValue          = ?,
            si_propertyCardNo  = ?,
            si_physicalCountNo = ?,
            si_SOQuantity      = ?,
            si_SOValue         = ?,
            si_issuedBy        = ?,
            si_dateIssued      = ?,
            si_dateReceived    = ?,
            si_status          = ?,
            si_propertyType    = ?,
            si_fundCluster     = ?,
            si_notes           = ?
        WHERE si_id = ? AND is_deleted = 0
    ");

    $updateItem->execute([
        $e_propertyNo,
        $e_serialNo,
        $e_icsNo,
        $e_item,
        $e_description,
        $e_uMeasurement,
        $e_uValue ?: null,
        $e_propertyCardNo ?: null,
        $e_physicalCountNo ?: null,
        $e_SOQuantity ?: null,
        $e_SOValue ?: null,
        $e_issuedBy,
        $e_dateIssued ?: null,
        $e_dateReceived ?: null,
        $e_status,
        $e_propertyType,
        $e_fundCluster,
        $e_notes,
        (int)$e_si_id
    ]);

    echo json_encode([
        "success" => true,
        "message" => "School item updated successfully.",
        "data"    => [
            "si_id"       => (int)$e_si_id,
            "si_item"     => $e_item,
            "si_propertyNo" => $e_propertyNo
        ]
    ]);

} catch (Exception $e) {

    error_log("Edit School Item Error: " . $e->getMessage());

    echo json_encode([
        "success" => false,
        "message" => "Failed to update school item. Error: " . $e->getMessage()
    ]);
}

?>