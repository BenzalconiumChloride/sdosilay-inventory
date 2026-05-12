<?php
ini_set('max_execution_time', 2400); //in seconds
ini_set('display_errors', 'On');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set("Asia/Manila");
$today_date1 = date("Y-m-d H:i:s");
$today_date2 = date("Y-m-d");
$today_date3 = date("M d, Y");
$today_date4 = date("M d, Y | h:i a");
$today_month = date("m");
$today_year = date("Y");
$today_day = date("l");
$today_time = date("H");
$today_a = date("a");

// database connection config
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'db_inventory';

// $dbHost = 'sql112.yzz.me';
// $dbUser = 'yzzme_40764471';
// $dbPass = '0211Sasuke';
// $dbName = 'yzzme_40764471_depedsilay';


try {
    
    $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e)
    { echo "Connection failed: " . $e->getMessage(); }

$link  = mysqli_connect("$dbHost","$dbUser","$dbPass","$dbName");

if(isset($_SESSION['user_id'])){ $userId = $_SESSION['user_id']; }else{ $userId = ""; }

# Get user details
$user = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId'");
$user->execute();
$user_data = $user->fetch();

// setting up the web root and server root for this website application
$thisFile = str_replace('\\', '/', __FILE__);
$docRoot = '/sdosilay-inventory/';

$srvRoot  = str_replace('global-library/database.php', '', $thisFile);
$webRoot  = '/sdosilay-inventory/';

if (!defined('WEB_ROOT')) {
    define('WEB_ROOT', $webRoot);
}

if (!defined('SRV_ROOT')) {
    define('SRV_ROOT', $srvRoot);
}
?>