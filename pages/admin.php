<?php session_start();
require_once '../util/session_helper.php';
if (!check_auth()) header('Location: ./register.php');
if (!is_admin()) header('Location: ./home.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../styles/main.css">
    <script src="../js/admin.js" defer></script>
</head>

<body>
    <h2>Dashboard</h2>
    <p>Total users: <span id="totalUsers">0</span></p>

    <input id="searchField" placeholder="Search by login/email" />
    <button id="searchBtn">Search</button>

    <table id="userTable" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Login</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <form action="../util/exit.php" method="post" id="exitForm">
        <button type="submit" id="exitBtn">Exit</button>
    </form>
</body>

</html>