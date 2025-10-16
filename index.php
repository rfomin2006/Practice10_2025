<?php
require_once './util/session_helper.php';
session_start();

header('Location: ' . (check_auth() ? './pages/home.php' : './pages/register.php'));