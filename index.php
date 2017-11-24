<?php include_once("inc/config.php"); ?>
<?php include_once("inc/PDO-mysql.php"); ?>
<?php include_once("inc/functions.php"); ?>
<?php include_once("inc/header.php"); ?>
<?php include_once("inc/navbar.php"); ?>

<?php
if ($debug == TRUE)
{
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}
?>

<?php
if (isset($_GET['home'])) $page = 1;
else if (isset($_GET['help'])) $page = 2;
else if (isset($_GET['login'])) $page = 3;
else if (isset($_GET['logout'])) $page = 4;
else if (isset($_GET['settings'])) $page = 5;
else {$page = 1;} 

echo '<div class="content">';
if ($page == 1) require("inc/home.php");
else if ($page == 2) require("inc/help.php");
else if ($page == 3) require("inc/login.php");
else if ($page == 4) require("inc/logout.php");
else if ($page == 5) require("inc/settings.php");
else require("inc/404.php");
echo '</div>';
?>

<?php include_once("inc/footer.php"); ?>