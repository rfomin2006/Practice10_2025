<?php
session_start();
require_once '../util/db.php';
require_once '../util/api_helper.php';
header('Content-Type: application/json'); // тип возвращаемого ответа - JSON

// response to OPTIONS and HEAD 200 - OK
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS' || $_SERVER['REQUEST_METHOD'] === 'HEAD') {
    http_response_code(200);
    die;
}

// main API logic
try {
    // get request
    $input = json_decode(file_get_contents('php://input'), true) ?? [];

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (!empty($_GET['login'])) { // get user by login
                $stmt = $pdo->prepare("SELECT id, login, email FROM users WHERE login = :login");
                $stmt->execute(['login' => $_GET['login']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                send_response(200, [$user]);
            } else { // get all users
                $stmt = $pdo->query("SELECT id, login, email FROM users");
                send_response(200, $stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

        case 'POST':
            $action = $input['action'] ?? null; // API action

            if ($action === 'register') { // register user
                if (empty($input['login']) || empty($input['email']) || empty($input['password'])) {
                    send_response(400, msg: 'Missing fields');
                }
                $stmt = $pdo->prepare("INSERT INTO users (login, email, password_hash)
                                                        VALUES (:login, :email, :hash)");
                $stmt->execute([
                    'login' => $input['login'],
                    'email' => $input['email'],
                    'hash' => password_hash($input['password'], PASSWORD_DEFAULT)
                ]);
                send_response(200, ['message' => 'User created']);
            } else if ($action === 'login') { // login user
                if (empty($input['login']) || empty($input['password'])) send_response(400, msg: 'Login and pasword required');
                $login = $input['login'];
                $password = $input['password'];
                $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE login = :login OR email = :login");
                $stmt->execute(['login' => $login]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$user) {
                    send_response(401, msg: 'User not found');
                }
                if (!password_verify($password, $user['password_hash'])) {
                    send_response(401, msg: 'Incorrect password');
                }
                // storing id in session
                $_SESSION['uid'] = $user['id'];
                send_response(200, ['message' => 'Login successful']);
            } else {
                send_response(400, msg: 'Unknown POST action');
            }
            break;

        default: // filter other methods
            send_response(405, msg: 'Method not allowed');
    }
} catch (PDOException $e) { // if database error
    send_response(500, msg: $e->getMessage());
}
