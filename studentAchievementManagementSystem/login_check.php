<?php
session_start();
if (!isset($_SESSION['login_user'])) {
    header('location: ../index.php');
}
$username = $_SESSION['login_user'];
?>