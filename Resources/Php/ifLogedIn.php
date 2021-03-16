<?php
ob_start();
session_start();
$login=false;
if (isset($_SESSION['login'])){
    $login=true;
}
?>

