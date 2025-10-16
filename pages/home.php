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
    <title>Home Page</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/home.css">
</head>

<body>
    <form action="./profile.php" method="post" id="profileForm">
        <button type="submit" id="profileBtn">Profile</button>
    </form>
    <h1>Hi!👋</h1>
    <form action="../util/exit.php" method="post" id="exitForm">
        <button type="submit" id="exitBtn">Exit</button>
    </form>
</body>

</html>