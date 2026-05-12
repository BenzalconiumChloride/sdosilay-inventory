<?php
require_once '../../../global-library/database.php';
header('Content-Type: application/json');
session_start();

try {

    if (empty($_SESSION['user_id'])) {
        throw new Exception('Unauthorized');
    }

    $id = (int)($_POST['tId'] ?? 0);
    if (!$id) {
        throw new Exception('Invalid ID');
    }

    $nHeader   = trim($_POST['nHeader'] ?? '');
    $nContent  = trim($_POST['nContent'] ?? '');
    $eventDate = trim($_POST['eventDate'] ?? '');
    $newsType  = trim($_POST['newsType'] ?? '');

    if (!$nHeader || !$nContent || !$newsType) {
        throw new Exception('Required fields missing');
    }

    if (!in_array($newsType, ['news','event','memo'])) {
        throw new Exception('Invalid news type');
    }

    if ($newsType !== 'event') {
        $eventDate = null;
    }

    // ===============================
    // IMAGE
    // ===============================
    $thumbnailSQL = '';
    $params = [
        $nHeader,
        $nContent,
        $eventDate,
        $newsType
    ];

    if (!empty($_FILES['thumbnail']['name'])) {

        $allowed = ['image/jpeg','image/png','image/gif'];
        $mime = mime_content_type($_FILES['thumbnail']['tmp_name']);

        if (!in_array($mime, $allowed)) {
            throw new Exception('Invalid image type');
        }

        $ext = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
        $thumbnail = uniqid('news_', true) . '.' . $ext;

        move_uploaded_file(
            $_FILES['thumbnail']['tmp_name'],
            SRV_ROOT.'administrator-page/assets/uploads/news/'.$thumbnail
        );

        $thumbnailSQL = ', thumbnail=?';
        $params[] = $thumbnail;
    }

    $params[] = $_SESSION['user_id'];
    $params[] = $id;

    $stmt = $conn->prepare("
        UPDATE tblnews
        SET
            nHeader=?,
            nContent=?,
            eventDate=?,
            newsType=?
            $thumbnailSQL,
            modifiedBy=?,
            dateModified=NOW()
        WHERE tId=?
          AND isDeleted=0
    ");

    $stmt->execute($params);

    echo json_encode([
        'success' => true,
        'message' => 'News updated successfully'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>