<?php
ob_start();
session_start();
if ($_SESSION['login']){
    //var_dump($_SESSION['email']);
    header('Location: index.php');
}
include 'db_connect.php';
$error='';
if (isset($_POST['register'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $passwordConfirm=$_POST['passwordConfirm'];
    if ($name!='' && $email!='' && $password!=''){
        if ($password == $passwordConfirm){
            $query="SELECT * FROM users WHERE email='$email'";
            $row=$db->query($query);
            if(mysqli_num_rows($row) > 0){
                $error='Email exist, This User registered before';
            }
            if ($error==''){
                $password=password_hash($password, PASSWORD_DEFAULT);
                $query="
            INSERT INTO users (name, email, password)
            VALUES ('$name', '$email', '$password')
            ";
                if ($db->query($query) === TRUE) {
                    echo "New record created successfully";
                } else {
                    $error = "Error: " . $query . "<br>" . $db->error;
                }
            }
        }else{
            $error='Password and Confirm Password should be same';
        }
    }else{
        $error='Please fill up all fields';
    }
}
