<?php

require_once __DIR__ . '/../../global-library/database.php';

header('Content-Type: application/json');

try {

    // ===============================
    // AUTH
    // ===============================

    if (empty($_SESSION['school_id'])) {
        throw new Exception('Unauthorized: Please log in first');
    }

    $school_id = $_SESSION['school_id'];

    // ===============================
    // INPUTS
    // ===============================

    $propertyNo      = trim($_POST['propertyNo'] ?? '');
    $serialNo        = trim($_POST['serialNo'] ?? '');
    $icsNo           = trim($_POST['icsNo'] ?? '');
    $item            = trim($_POST['item'] ?? '');
    $description     = trim($_POST['description'] ?? '');
    $uMeasurement    = trim($_POST['uMeasurement'] ?? '');
    $uValue          = trim($_POST['uValue'] ?? '');
    $propertyCardNo  = trim($_POST['propertyCardNo'] ?? '');
    $physicalCountNo = trim($_POST['physicalCountNo'] ?? '');
    $SOQuantity      = trim($_POST['SOQuantity'] ?? '');
    $SOValue         = trim($_POST['SOValue'] ?? '');
    $issuedBy        = trim($_POST['issuedBy'] ?? '');
    $dateIssued      = trim($_POST['dateIssued'] ?? '');
    $dateReceived    = trim($_POST['dateReceived'] ?? '');
    $status          = trim($_POST['status'] ?? '');
    $notes           = trim($_POST['notes'] ?? '');
    $propertyType    = trim($_POST['propertyType'] ?? '');
    $fundCluster     = trim($_POST['fundCluster'] ?? '');

    // Validate required fields
    if (!$propertyNo || !$item) {
        throw new Exception('Property Number and Item Name are required');
    }

    // ===============================
    // INSERT INTO DATABASE
    // ===============================

    $sql = "INSERT INTO tbl_schoolitems (
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
        si_dateReceived,
        si_status,
        si_notes,
        si_propertyType,
        si_fundCluster,
        is_deleted
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0
    )";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Database error: ' . $conn->errorInfo()[2]);
    }

    $success = $stmt->execute([
        $school_id,
        $propertyNo,
        $serialNo,
        $icsNo,
        $item,
        $description,
        $uMeasurement,
        $uValue,
        $propertyCardNo,
        $physicalCountNo,
        $SOQuantity,
        $SOValue,
        $issuedBy,
        $dateIssued,
        $dateReceived,
        $status,
        $notes,
        $propertyType,
        $fundCluster
    ]);

    if (!$success) {
        throw new Exception('Error adding school item: ' . $stmt->errorInfo()[2]);
    }

    echo json_encode([
        'success' => true,
        'message' => 'School item added successfully'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

?>
