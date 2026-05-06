<?php

if (!defined('WEB_ROOT')) {

    header('Location: ../index.php');

    exit;
}



$self = WEB_ROOT . 'index.php';



?>

<!DOCTYPE html>



<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">



<head>

    <meta charset="utf-8">

    <link rel="icon" href="<?php echo WEB_ROOT; ?>assets/images/favicon.png" type="image/png" />

    <title>DepEd Silay</title>



    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">



    <?php include($_SERVER["DOCUMENT_ROOT"] . '/' . $webRoot . '/include/global-css.php'); ?>





</head>



<body>

    <div class="overlay" id="overlay" onclick="closeSidebar()"></div>

    <div class="shell">

        <?php include($_SERVER["DOCUMENT_ROOT"] . '/' . $webRoot . '/include/left-menu.php'); ?>
        <div class="main">

            <?php include($_SERVER["DOCUMENT_ROOT"] . '/' . $webRoot . '/include/header.php'); ?>

            <div class="content-wrap">
                <main class="content-main">
                    <?php require_once $content; ?>
                </main>
            </div>
        </div>

        <?php include($_SERVER["DOCUMENT_ROOT"] . '/' . $webRoot . '/include/global-js.php'); ?>
    </div>


</body>



</html>