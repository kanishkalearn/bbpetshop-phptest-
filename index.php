<?php
session_start();
if(!isset($_SESSION['username'])){
    $_SESSION['username']="";
    header('location:index.php');
}else{
    header('location:home.php');
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <a href="login.php">Login</a>
        
    </body>
</html>
