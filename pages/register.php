<? session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/forms.css">
</head>
<body>
    <form id="registerForm">
        <h2>Register</h2>
        <input type="text" name="login" id="login" placeholder="login">
        <input type="email" name="email" id="email" placeholder="email">
        <input type="password" name="password" id="password" placeholder="password">
        <button id="regBtn">Register</button>
        <p class="authPromt">Already have account? <a href="./login.php">Log in</a></p>
    </form>
</body>
</html>