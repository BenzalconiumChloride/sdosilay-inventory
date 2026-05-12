<?php
require_once '../../global-library/database.php';

if (isset($_GET['news-and-updates'])) {
    $view = 'news';
} else {
    $view = '';
}

$currentPage = 'news';

switch ($view) {
    case 'news':
        $content   = 'news.php';
        $pageTitle = 'news';
        break;

    default:
        $content   = 'news.php';
        $pageTitle = 'news';
        break;
}

require_once '../include/template.php';
?>