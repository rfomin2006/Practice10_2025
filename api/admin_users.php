<?php session_start();
require_once '../util/db.php';
require_once '../util/api_helper.php';
require_once '../util/session_helper.php';

if (!isset($_SESSION['uid']) || !is_admin()) {
    send_response(403, msg: 'Access denied');
    die;
}

try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $page = max(1, (int)($_GET['page'] ?? 1));
            $limit = 10;
            $offset = ($page - 1) * $limit;
            $search = $_GET['search'] ?? '';

            $params = [];
            $where = '';

            if ($search !== '') {
                $where = " WHERE login LIKE :search OR email LIKE :search";
                $params['search'] = "%$search%";
            }

            $query = "SELECT id, login, email, is_admin FROM users" . $where . " ORDER BY id DESC LIMIT $limit OFFSET $offset";
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $countQuery = "SELECT COUNT(*) as total FROM users" . $where;
            $countStmt = $pdo->prepare($countQuery);
            $countStmt->execute($params);
            $total = $countStmt->fetch()['total'];

            send_response(200, [
                'users' => $users,
                'total' => (int)$total,
                'page' => $page,
            ]);
            die;

        case 'PATCH':
            // edit user
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? null;
            if (!$id) send_response(400, msg: 'Missing user ID');

            $fields = [];
            $params = ['id' => $id];

            if (!empty($input['login'])) {
                $fields[] = "login = :login";
                $params['login'] = $input['login'];
            }
            if (!empty($input['email'])) {
                $fields[] = "email = :email";
                $params['email'] = $input['email'];
            }
            if (!empty($input['is_admin'])) {
                $fields[] = "is_admin = :is_admin";
                $params['is_admin'] = $input['is_admin'];
            }

            if (empty($fields)) send_response(400, msg: 'Nothing to update');

            $stmt = $pdo->prepare("UPDATE users SET " . implode(',', $fields) . " WHERE id = :id");
            $stmt->execute($params);
            send_response(200, ['message' => 'User updated']);
            die;

        case 'DELETE':
            // delete user
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? null;
            if (!$id) send_response(400, msg: 'Missing user ID');

            $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);
            send_response(200, ['message' => 'User deleted']);
            die;

        default:
            send_response(405, msg: 'Method not allowed');
    }
} catch (PDOException $e) {
    send_response(500, msg: $e->getMessage());
    die;
}
