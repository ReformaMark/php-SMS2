<?php 
require_once 'config_session.php';

session_start();
session_unset();
session_destroy();

header("Location: https://schoolmanagementsystem2.com/login.php");
exit();
