<?php
$db= new mysqli("localhost","root","root","green_city");
if($db->connect_error){
    die("Failed to connect" .$db->connect_error);
}
