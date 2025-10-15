<?php
require_once '../util/db.php';
require_once '../util/api_helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS' || $_SERVER['REQUEST_METHOD'] === 'HEAD') {
    http_response_code(200);
    die;
}
try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['login'])) {
            $stmt = $pdo->prepare("SELECT id, login, email FROM users WHERE login = :login");
            $stmt->execute(["login" => $data['login']]);
            $users = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $users = $pdo->query("SELECT id, login, email FROM users")->fetchAll(PDO::FETCH_ASSOC);
        }
        send_response(200, $users);
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['login'], $data['email'], $data['password'])) {
            $stmt = $pdo->prepare("INSERT INTO users (login, email, password_hash) 
                                            VALUES (:login, :email, :password_hash)");
            $stmt->execute([
                'login' => $data['login'],
                'email' => $data['email'],
                'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT)
            ]);
            send_response(200, ['redirect' => '../pages/login.php']);
        } else {
            send_response(400, msg: 'Bad request');
        }
    } else {
        send_response(405, msg: 'Method not allowed');
    }
} catch (PDOException $e) {
    send_response(500, msg: $e->getMessage());
}
