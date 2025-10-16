<?php session_start();
require_once '../util/session_helper.php';
if (!check_auth()) header('Location: ./register.php');
if (!is_admin()) header('Location: ./home.php');

?>