<?php
require_once '../../../global-library/database.php';
header('Content-Type: application/json');

try {

    // ===============================
    // FETCH SINGLE (EDIT)
    // ===============================
    if (!empty($_GET['id'])) {

        $id = (int) $_GET['id'];

        $stmt = $conn->prepare("
            SELECT
                tId,
                nHeader,
                nSubHeader,
                nContent,
                thumbnail,
                eventDate,
                newsType,
                dateAdded
            FROM tblnews
            WHERE tId = ?
              AND isDeleted = 0
            LIMIT 1
        ");

        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode([
            'success' => (bool) $data,
            'data'    => $data
        ]);
        exit;
    }

    // ===============================
    // FETCH ALL (TABLE)
    // ===============================
    $stmt = $conn->prepare("
        SELECT
            tId,
            nHeader,
            nContent,
            thumbnail,
            eventDate,
            newsType,
            dateAdded
        FROM tblnews
        WHERE isDeleted = 0
        ORDER BY 
            CASE 
                WHEN eventDate IS NOT NULL THEN STR_TO_DATE(eventDate, '%Y-%m-%d')
                ELSE STR_TO_DATE(dateAdded, '%Y-%m-%d %H:%i:%s')
            END DESC
    ");

    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data'    => $rows
    ]);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Fetch failed'
    ]);
}
?>