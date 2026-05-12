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

    $sql = "UPDATE tbl_schoolitems SET is_deleted = 1 WHERE si_id = ? AND s_id = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Database error: ' . $conn->errorInfo()[2]);
    }

    $success = $stmt->execute([$id, $school_id]);

    if (!$success) {
        throw new Exception('Error deleting record: ' . $stmt->errorInfo()[2]);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Record deleted successfully'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
