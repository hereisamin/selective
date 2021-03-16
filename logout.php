<?php
include 'Resources/Php/ifLogedIn.php';
if ($login){
    unset($_SESSION['login']);
    unset($_SESSION['timeout']);
    unset($_SESSION['email']);
    header('Location: index.php');
}else{
    header('Location: index.php');
}
