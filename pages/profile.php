<?php session_start();
require_once '../util/session_helper.php';
if (!check_auth()) header('Location: ./register.php');
if (is_admin()) header('Location: ./admin.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/profile.css">
</head>
<body>
    
</body>
</html>