<?php
session_start();
require_once('../../database.php');
$link = db_connect();

$remember = $_POST['remember'];
$login  = $_POST['login'];
$password = $_POST['password'];
$query = mysqli_query($link, "SELECT * FROM `Users` WHERE `login`='$login' AND `password`='$password'");

if (mysqli_num_rows($query)>0)
{
    $user= mysqli_fetch_assoc($query);
    $_SESSION['user']=[
        "id"=>$user['user_id'],
        "login"=>$user['login'],
        "email"=>$user['email'],
        "admin"=>$user['admin']
    ];
    if ($remember){
        setcookie('login', $login, time()+3600*24,'/');
        setcookie('password', $password, time()+3600*24,'/');
    }
    header('Location: ../../templates/index.html');
     
}
else{
    echo '<div style="color:red;">Неверный логин или пароль</div>';
}
?>