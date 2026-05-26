<?php

require_once '../../global-library/database.php';

if (isset($_GET['view']) && $_GET['view'] === 'school-items' && isset($_GET['s_id'])) {
    $view = 'school-items';
} else {
    $view = 'schools';
}

switch ($view) {
    case 'school-items':
        $content   = 'school-items-view.php';
        $pageTitle = 'School Items';
        break;

    default:
        $content   = 'school-items.php';
        $pageTitle = 'Schools';
        break;
}

require_once '../include/template.php';

?>