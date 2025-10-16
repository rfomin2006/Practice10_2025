<?php session_start();
require_once '../util/db.php';
require_once '../util/api_helper.php';

if (!isset($_SESSION['uid'])) {
    send_response(401, msg: 'Unauthorized');
    die;
}

$user_id = $_SESSION['uid'];
$input = json_decode(file_get_contents('php://input'), true) ?? [];

try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case ('GET'):
            // get user by id
            $stmt = $pdo->prepare("SELECT id, login, email FROM users WHERE id = :id");
            $stmt->execute(['id' => $user_id]);
            send_response(200, $stmt->fetch(PDO::FETCH_ASSOC));
            die;
            break;
        case 'PATCH':
            // update profile
            $fields = [];
            $params = ['id' => $user_id];

            // change login and email
            if (!empty($input['login'])) {
                $fields[] = "login = :login";
                $params['login'] = $input['login'];
            }

            if (!empty($input['email'])) {
                $fields[] = "email = :email";
                $params['email'] = $input['email'];
            }

            // change password
            if (!empty($input['old_password']) && !empty($input['new_password'])) {
                $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = :id");
                $stmt->execute(['id' => $user_id]);
                $user = $stmt->fetch();

                if (!$user || !password_verify($input['old_password'], $user['password_hash'])) {
                    send_response(401, msg: 'Wrong old password');
                    die;
                }

                $fields[] = "password_hash = :hash";
                $params['hash'] = password_hash($input['new_password'], PASSWORD_DEFAULT);
            }

            if (!empty($fields)) {
                $stmt = $pdo->prepare("UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id");
                $stmt->execute($params);
                send_response(200, ['message' => 'Profile updated']);
                die;
            } else {
                send_response(400, msg: 'No fields to update');
                die;
            }
            break;
    }
} catch (PDOException $e) {
    send_response(500, msg: $e->getMessage());
    die;
}
