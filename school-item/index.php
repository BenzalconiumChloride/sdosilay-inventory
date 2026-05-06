<?php
require_once '../global-library/database.php';
// require_once '../general-library/auth.php'; // Comment out or remove this line
// require_once '../include/config.php';

if (isset($_GET['school-item'])) {
    $view = 'school-item';
} else {
    $view = '';
}

$currentPage = 'school-item';

switch ($view) {
    case 'school-item':
        $content   = 'school-item.php';
        $pageTitle = 'School Items';
        break;

    default:
        $content   = 'school-item.php';
        $pageTitle = 'School Items';
        break;
}

require_once '../include/template.php';
?>