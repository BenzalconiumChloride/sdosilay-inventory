<?php
require_once '../../../global-library/database.php';
header('Content-Type: application/json');
session_start();

try {

    // ===============================
    // AUTH
    // ===============================
    if (empty($_SESSION['user_id'])) {
        throw new Exception('Unauthorized');
    }

    // ===============================
    // INPUTS
    // ===============================
    $nHeader     = trim($_POST['nHeader'] ?? '');
    $nSubHeader  = trim($_POST['nSubHeader'] ?? '');
    $nContent    = trim($_POST['nContent'] ?? '');
    $eventDate   = trim($_POST['eventDate'] ?? '');
    $newsType    = trim($_POST['newsType'] ?? '');

    if (!$nHeader || !$nContent || !$newsType) {
        throw new Exception('Required fields missing');
    }

    if (!in_array($newsType, ['news', 'event', 'memo'])) {
        throw new Exception('Invalid news type');
    }

    // Event date only for event
    if ($newsType === 'event' && !$eventDate) {
        throw new Exception('Event date is required for events');
    }

    if ($newsType !== 'event') {
        $eventDate = null;
    }

    // ===============================
    // MULTIPLE IMAGES
    // ===============================
    $uploadedImages = [];
    $thumbnail = null; // First image only

    if (!empty($_FILES['images']['name'][0])) {

        $allowed = ['image/jpeg', 'image/png', 'image/gif'];
        $uploadDir = SRV_ROOT . 'administrator-page/assets/uploads/news/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Loop through each uploaded file
        $fileCount = count($_FILES['images']['name']);
        
        for ($i = 0; $i < $fileCount; $i++) {
            
            // Skip if error
            if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) {
                continue;
            }

            // Validate MIME type
            $tmpName = $_FILES['images']['tmp_name'][$i];
            $mime = mime_content_type($tmpName);

            if (!in_array($mime, $allowed)) {
                throw new Exception('Invalid image type for file ' . ($i + 1));
            }

            // Validate file size (10MB)
            if ($_FILES['images']['size'][$i] > 10 * 1024 * 1024) {
                throw new Exception('File ' . ($i + 1) . ' exceeds 10MB limit');
            }

            // Generate unique filename
            $ext = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
            $filename = uniqid('news_', true) . '_' . $i . '.' . $ext;

            // Move file
            if (move_uploaded_file($tmpName, $uploadDir . $filename)) {
                $uploadedImages[] = $filename;
                
                // Set ONLY first image as thumbnail (database limitation)
                if ($i === 0) {
                    $thumbnail = $filename;
                }
            } else {
                throw new Exception('Failed to upload file ' . ($i + 1));
            }
        }
    }

    // ===============================
    // INSERT (MATCHES tblnews)
    // ===============================
    $stmt = $conn->prepare("
        INSERT INTO tblnews (
            nHeader,
            nSubHeader,
            nContent,
            thumbnail,
            eventDate,
            newsType,
            addedBy,
            dateAdded,
            isDeleted
        ) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 0)
    ");

    $stmt->execute([
        $nHeader,
        $nSubHeader ?: null,
        $nContent,
        $thumbnail,
        $eventDate,
        $newsType,
        $_SESSION['user_id']
    ]);

    $newsId = $conn->lastInsertId();

    // ===============================
    // STORE ADDITIONAL IMAGES IN SEPARATE TABLE
    // ===============================
    if (count($uploadedImages) > 1) {
        $imgStmt = $conn->prepare("
            INSERT INTO tblnews_images (news_id, image_path, display_order, dateAdded)
            VALUES (?, ?, ?, NOW())
        ");

        foreach ($uploadedImages as $index => $imageName) {
            $imgStmt->execute([$newsId, $imageName, $index]);
        }
    }

    echo json_encode([
        'success' => true,
        'message' => ucfirst($newsType) . ' added successfully',
        'images_uploaded' => count($uploadedImages)
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>