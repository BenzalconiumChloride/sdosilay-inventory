<?php
require_once '../../../global-library/database.php';

header('Content-Type: application/json');

$addedBy    = $_SESSION['user_id'] ?? 0;
$today_date = date("Y-m-d H:i:s");

try {

    $i_propertyNo      = trim($_POST['i_propertyNo']      ?? '');
    $i_serialNo        = trim($_POST['i_serialNo']        ?? '');
    $i_icsNo           = trim($_POST['i_icsNo']           ?? '');
    $i_propertyType    = trim($_POST['i_propertyType']    ?? '');
    $i_fundCluster     = trim($_POST['i_fundCluster']     ?? '');
    $i_item            = trim($_POST['i_item']            ?? '');
    $i_description     = trim($_POST['i_description']     ?? '');
    $i_uMeasurement    = trim($_POST['i_uMeasurement']    ?? '');
    $i_uValue          = trim($_POST['i_uValue']          ?? '');
    $i_propertyCardNo  = trim($_POST['i_propertyCardNo']  ?? '');
    $i_physicalCountNo = trim($_POST['i_physicalCountNo'] ?? '');
    $i_SOQuantity      = trim($_POST['i_SOQuantity']      ?? '');
    $i_SOValue         = trim($_POST['i_SOValue']         ?? '');
    $i_dateReceived    = trim($_POST['i_dateReceived']    ?? '');
    $i_issuedBy        = trim($_POST['i_issuedBy']        ?? '');
    $i_issuedTo        = trim($_POST['i_issuedTo']        ?? '');
    $i_dateIssued      = trim($_POST['i_dateIssued']      ?? '');
    $i_transferredTo   = trim($_POST['i_transferredTo']   ?? '');
    $i_dateTransferred = trim($_POST['i_dateTransferred'] ?? '');
    $i_status          = trim($_POST['i_status']          ?? '');
    $i_notes           = trim($_POST['i_notes']           ?? '');

    if (empty($i_propertyNo) || empty($i_serialNo) || empty($i_icsNo) || empty($i_item) || empty($i_uMeasurement)) {
        throw new Exception("Property Number, Serial Number, ICS Number, Item Name, and Unit of Measure are required.");
    }

    $insertItem = $conn->prepare("
        INSERT INTO tbl_items (
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
            i_notes,
            is_deleted
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)
    ");

    $insertItem->execute([
        $i_propertyNo,
        $i_serialNo,
        $i_icsNo,
        $i_propertyType,
        $i_fundCluster,
        $i_item,
        $i_description,
        $i_uMeasurement,
        $i_uValue,
        $i_propertyCardNo,
        $i_physicalCountNo,
        $i_SOQuantity,
        $i_SOValue,
        $i_dateReceived,
        $i_issuedBy,
        $i_issuedTo,
        $i_dateIssued,
        $i_transferredTo,
        $i_dateTransferred,
        $i_status,
        $i_notes
    ]);

    $item_id = $conn->lastInsertId();

    echo json_encode([
        "success" => true,
        "message" => "Item added successfully.",
        "data"    => [
            "itemId"       => $item_id,
            "i_item"       => $i_item,
            "i_propertyNo" => $i_propertyNo
        ]
    ]);

} catch (Exception $e) {

    error_log("Add Item Error: " . $e->getMessage());

    echo json_encode([
        "success" => false,
        "message" => "Failed to add item. Error: " . $e->getMessage()
    ]);
}

?>