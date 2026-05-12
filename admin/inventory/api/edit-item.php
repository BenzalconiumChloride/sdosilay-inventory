<?php
require_once '../../../global-library/database.php';

header('Content-Type: application/json');

try {

    $e_id              = trim($_POST['e_id']             ?? '');
    $e_propertyNo      = trim($_POST['e_propertyNo']     ?? '');
    $e_serialNo        = trim($_POST['e_serialNo']       ?? '');
    $e_icsNo           = trim($_POST['e_icsNo']          ?? '');
    $e_propertyType    = trim($_POST['e_propertyType']   ?? '');
    $e_fundCluster     = trim($_POST['e_fundCluster']    ?? '');
    $e_item            = trim($_POST['e_item']           ?? '');
    $e_description     = trim($_POST['e_description']   ?? '');
    $e_uMeasurement    = trim($_POST['e_uMeasurement']  ?? '');
    $e_uValue          = trim($_POST['e_uValue']         ?? '');
    $e_propertyCardNo  = trim($_POST['e_propertyCardNo'] ?? '');
    $e_physicalCountNo = trim($_POST['e_physicalCountNo']?? '');
    $e_SOQuantity      = trim($_POST['e_SOQuantity']     ?? '');
    $e_SOValue         = trim($_POST['e_SOValue']        ?? '');
    $e_dateReceived    = trim($_POST['e_dateReceived']   ?? '');
    $e_issuedBy        = trim($_POST['e_issuedBy']       ?? '');
    $e_issuedTo        = trim($_POST['e_issuedTo']       ?? '');
    $e_dateIssued      = trim($_POST['e_dateIssued']     ?? '');
    $e_transferredTo   = trim($_POST['e_transferredTo']  ?? '');
    $e_dateTransferred = trim($_POST['e_dateTransferred']?? '');
    $e_status          = trim($_POST['e_status']         ?? '');
    $e_notes           = trim($_POST['e_notes']          ?? '');

    if (empty($e_id) || !is_numeric($e_id)) {
        throw new Exception("Invalid or missing item ID.");
    }

    if (empty($e_propertyNo) || empty($e_serialNo) || empty($e_icsNo) || empty($e_item) || empty($e_uMeasurement)) {
        throw new Exception("Property Number, Serial Number, ICS Number, Item Name, and Unit of Measure are required.");
    }

    $updateItem = $conn->prepare("
        UPDATE tbl_items SET
            i_propertyNo      = ?,
            i_serialNo        = ?,
            i_icsNo           = ?,
            i_propertyType    = ?,
            i_fundCluster     = ?,
            i_item            = ?,
            i_description     = ?,
            i_uMeasurement    = ?,
            i_uValue          = ?,
            i_propertyCardNo  = ?,
            i_physicalCountNo = ?,
            i_SOQuantity      = ?,
            i_SOValue         = ?,
            i_dateReceived    = ?,
            i_issuedBy        = ?,
            i_issuedTo        = ?,
            i_dateIssued      = ?,
            i_transaferedTo   = ?,
            i_dateTransferred = ?,
            i_status          = ?,
            i_notes           = ?
        WHERE i_id = ? AND is_deleted = 0
    ");

    $updateItem->execute([
        $e_propertyNo,
        $e_serialNo,
        $e_icsNo,
        $e_propertyType,
        $e_fundCluster,
        $e_item,
        $e_description,
        $e_uMeasurement,
        $e_uValue,
        $e_propertyCardNo,
        $e_physicalCountNo,
        $e_SOQuantity,
        $e_SOValue,
        $e_dateReceived,
        $e_issuedBy,
        $e_issuedTo,
        $e_dateIssued,
        $e_transferredTo,
        $e_dateTransferred,
        $e_status,
        $e_notes,
        (int)$e_id
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Item updated successfully.",
        "data"    => [
            "itemId"       => (int)$e_id,
            "i_item"       => $e_item,
            "i_propertyNo" => $e_propertyNo
        ]
    ]);

} catch (Exception $e) {

    error_log("Edit Item Error: " . $e->getMessage());

    echo json_encode([
        "success" => false,
        "message" => "Failed to update item. Error: " . $e->getMessage()
    ]);
}

?>