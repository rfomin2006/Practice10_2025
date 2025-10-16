<?php
session_start();
require_once '../util/db.php';
require_once '../util/api_helper.php';

// main API logic
try {
    // get request
    $input = json_decode(file_get_contents('php://input'), true) ?? [];

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (!empty($_GET['login'])) { // get user by login
                $stmt = $pdo->prepare("SELECT id, login, email, is_admin FROM users WHERE login = :login");
                $stmt->execute(['login' => $_GET['login']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                send_response(200, [$user]);
                die;
            } else { // get all users
                $stmt = $pdo->query("SELECT id, login, email, is_admin FROM users");
                send_response(200, $stmt->fetchAll(PDO::FETCH_ASSOC));
                die;
            }
            break;

        case 'POST':
            $action = $input['action'] ?? null; // API action

            if ($action === 'register') { // register user
                if (empty($input['login']) || empty($input['email']) || empty($input['password'])) {
                    send_response(400, msg: 'Missing fields');
                    die;
                }
                $stmt = $pdo->prepare("INSERT INTO users (login, email, password_hash)
                                                        VALUES (:login, :email, :hash)");
                $stmt->execute([
                    'login' => $input['login'],
                    'email' => $input['email'],
                    'hash' => password_hash($input['password'], PASSWORD_DEFAULT)
                ]);
                send_response(200, ['message' => 'User created']);
                die;
            } else if ($action === 'login') { // login user
                if (empty($input['login']) || empty($input['password'])) send_response(400, msg: 'Login and pasword required');
                $login = $input['login'];
                $password = $input['password'];
                $stmt = $pdo->prepare("SELECT id, password_hash, is_admin FROM users WHERE login = :login OR email = :login");
                $stmt->execute(['login' => $login]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$user) {
                    send_response(401, msg: 'User not found');
                    die;
                }
                if (!password_verify($password, $user['password_hash'])) {
                    send_response(401, msg: 'Incorrect password');
                    die;
                }
                // storing id in session
                $_SESSION['uid'] = $user['id'];
                $_SESSION['is_admin'] = ($user['is_admin'] > 0);
                send_response(
                    200,
                    [
                        'message' => 'Login successful',
                        'is_admin' => ($user['is_admin'] > 0)
                    ]
                );
                die;
            } else {
                send_response(400, msg: 'Unknown POST action');
                die;
            }
            break;

        default: // filter other methods
            send_response(405, msg: 'Method not allowed');
            die;
    }
} catch (PDOException $e) { // if database error
    send_response(500, msg: $e->getMessage());
    die;
}
