<?php
require_once __DIR__ . '/../../global-library/database.php';
header('Content-Type: application/json');

try {
    if (empty($_SESSION['school_id'])) {
        throw new Exception('Unauthorized: Please log in first');
    }

    $school_id = $_SESSION['school_id'];
    $id = trim($_POST['id'] ?? '');
    
    if (!$id) {
        throw new Exception('Record ID is required');
    }

    $propertyNo   = trim($_POST['propertyNo'] ?? '');
    $serialNo     = trim($_POST['serialNo'] ?? '');
    $icsNo        = trim($_POST['icsNo'] ?? '');
    $item         = trim($_POST['item'] ?? '');
    $description  = trim($_POST['description'] ?? '');
    $status       = trim($_POST['status'] ?? '');
    $SOQuantity   = trim($_POST['SOQuantity'] ?? '');

    if (!$propertyNo || !$item) {
        throw new Exception('Property Number and Item Name are required');
    }

    $sql = "UPDATE tbl_schoolitems SET 
            si_propertyNo = ?, 
            si_serialNo = ?, 
            si_icsNo = ?, 
            si_item = ?, 
            si_description = ?, 
            si_status = ?, 
            si_SOQuantity = ? 
            WHERE si_id = ? AND s_id = ?";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Database error: ' . $conn->errorInfo()[2]);
    }

    $success = $stmt->execute([
        $propertyNo,
        $serialNo,
        $icsNo,
        $item,
        $description,
        $status,
        $SOQuantity,
        $id,
        $school_id
    ]);

    if (!$success) {
        throw new Exception('Error updating record: ' . $stmt->errorInfo()[2]);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Record updated successfully'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
