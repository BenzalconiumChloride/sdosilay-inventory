<?php

require_once '../../global-library/database.php';



if (isset($_GET['inventory'])) {

    $view = 'inventory';

} else {

    $view = '';

}



$currentPage = 'inventory';

switch ($view) {
    case 'inventory':
        $content   = 'inventory.php';
        $pageTitle = 'Inventory';
        break;

    default:

        $content   = 'inventory.php';

        $pageTitle = 'Inventory';

        break;

}



require_once '../include/template.php';

?>