<?php
require_once '../global-library/database.php';
// require_once '../general-library/auth.php'; // Comment out or remove this line
// require_once '../include/config.php';

if (isset($_GET['citizen-charter'])) {
    $view = 'citizen-charter';
} else {
    $view = '';
}

$currentPage = 'citizen-charter';

switch ($view) {
    case 'citizen-charter':
        $content   = 'citizen-charter.php';
        $pageTitle = 'Citizen Charter';
        break;

    default:
        $content   = 'citizen-charter.php';
        $pageTitle = 'Citizen Charter';
        break;
}

require_once '../include/template.php';
?>