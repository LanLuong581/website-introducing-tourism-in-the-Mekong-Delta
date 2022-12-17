<?php
session_start();
    // session_destroy();
    if(isset($_SESSION['acc_email'])&& !empty($_SESSION['acc_email'])){
        unset($_SESSION['acc_email']);
        header("location:./login.php");
    } 
?>