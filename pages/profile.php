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
    <script src="../js/profile.js" defer></script>
</head>

<body>
    <h1>Profile</h1>
    <section id="profileSection">
        <form id="profileForm">
            <label>
                Login:
                <input type="text" id="login" name="login">
            </label>
            <label>
                Email:
                <input type="email" id="email" name="email">
            </label>
            <button id="saveProfileBtn">Save</button>
        </form>
    </section>

    <section id="passwordSection">
        <h3>Change password</h3>
        <form id="passwordForm">
            <label>
                Old password:
                <input type="password" id="old_password" name="old_password">
            </label>
            <label>
                New password:
                <input type="password" id="new_password" name="new_password">
            </label>
            <button id="changePasswordBtn">Change</button>
        </form>
    </section>

    <p id="message"></p>
    <form action="../util/exit.php" method="post" id="exitForm">
        <button type="submit" id="exitBtn">Exit</button>
    </form>
</body>

</html>