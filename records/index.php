<?php
require_once '../global-library/database.php';

if (isset($_GET['records'])) {
    $view = 'records';
} else {
    $view = '';
}

$currentPage = 'records';

switch ($view) {
    case 'records':
        $content   = 'records.php';
        $pageTitle = 'School Item Records';
        break;

    default:
        $content   = 'records.php';
        $pageTitle = 'School Item Records';
        break;
}

require_once '../include/template.php';
?>
