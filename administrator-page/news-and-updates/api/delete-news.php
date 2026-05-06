<?php
require_once '../../../global-library/database.php';
header('Content-Type: application/json');
session_start();

try {
    if (empty($_SESSION['user_id'])) throw new Exception('Unauthorized');

    $id = (int)($_POST['tId'] ?? 0);
    if (!$id) throw new Exception('Invalid ID');

    $stmt = $conn->prepare("UPDATE tblnews SET isDeleted=1 WHERE tId=?");
    $stmt->execute([$id]);

    echo json_encode(['success'=>true]);

} catch (Exception $e) {
    echo json_encode(['success'=>false,'message'=>$e->getMessage()]);
}
?>