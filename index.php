<?php
session_start();

header('Location: ' . (isset($_SESSION['uid']) ? './pages/home.php' : './pages/register.php'));