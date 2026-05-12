<?php
require_once '../../../global-library/database.php';

header('Content-Type: application/json');

try {

    $stmt = $conn->prepare("
        SELECT
            s.s_id,
            s.s_schoolId,
            s.s_schoolName,
            s.s_dateCreated,
            s.lastLogin,
            COUNT(si.si_id) AS total_items
        FROM tbl_schools s
        LEFT JOIN tbl_schoolitems si
            ON si.s_id = s.s_id
            AND si.is_deleted = 0
        WHERE s.is_deleted = 0
        GROUP BY
            s.s_id,
            s.s_schoolId,
            s.s_schoolName,
            s.s_dateCreated,
            s.lastLogin
        ORDER BY s.s_schoolName ASC
    ");

    $stmt->execute();
    $schools = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "message" => "Schools fetched successfully.",
        "data"    => $schools
    ]);

} catch (Exception $e) {

    error_log("Fetch Schools Error: " . $e->getMessage());

    echo json_encode([
        "success" => false,
        "message" => "Failed to fetch schools. Error: " . $e->getMessage()
    ]);
}

?>