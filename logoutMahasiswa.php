<?php 
    session_start();
    session_destroy();
    unset($_SESSION['nama']);
    unset($_SESSION['nim']);

    header("Location:login.php");
?>