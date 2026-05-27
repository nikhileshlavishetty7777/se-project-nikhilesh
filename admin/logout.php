<?php 
include('../Customer/config/constants.php');
//session_destroy();
unset($_SESSION['user-admin']);
header('location:'.SITEURL.'login.php');
?>