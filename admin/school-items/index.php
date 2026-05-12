<?php

require_once '../../global-library/database.php';



if (isset($_GET['school-items'])) {

    $view = 'school-items';

} else {

    $view = '';

}



$currentPage = 'school-items';

switch ($view) {
    case 'school-items':
        $content   = 'school-items.php';
        $pageTitle = 'School Items';
        break;

    default:

        $content   = 'school-items.php';

        $pageTitle = 'School Items';

        break;

}



require_once '../include/template.php';

?>