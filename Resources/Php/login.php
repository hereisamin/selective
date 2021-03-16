<?php
include 'ifLogedIn.php';
if ($login){
    header('Location: index.php');
}
include 'db_connect.php';
$error='';
if (isset($_POST['login'])){
    if (!empty($_POST['email']) && !empty($_POST['password'])){
        $email=$_POST['email'];
        $password=$_POST['password'];
        $query="
        SELECT email, password FROM users WHERE email='".$email."' LIMIT 1
        ";
        $result=$db->query($query);
        if (mysqli_num_rows($result) > 0){
            $result=mysqli_fetch_row($result);
            var_dump($result[1]);
            if(password_verify($password, $result[1])){
                $_SESSION['login'] = true;
                $_SESSION['timeout'] = time();
                $_SESSION['email'] = $result[0];
                header('Location: index.php');
            }else{
                $error='Email or Password is Wrong';
            }
        }else{
            $error='Email or Password is Wrong';
        }
    }else{
        $error='Input valid Email and Password';
    }
}
