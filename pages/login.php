<?php session_start();
require_once '../util/session_helper.php';
if (check_auth()) header('Location: ./home.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/forms.css">
    <script src="../js/login.js" defer></script>
</head>

<body>
    <form id="loginForm">
        <h2>Login</h2>
        <input type="text" name="login" id="login" placeholder="login" required>
        <input type="password" name="password" id="password" placeholder="password" required>
        <button id="loginBtn">Login</button>
        <p class="authPromt">Doesn'n have account? <a href="./register.php">Register</a></p>
    </form>
</body>

</html>