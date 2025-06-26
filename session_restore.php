<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) && isset($_COOKIE['remembered_user'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$_COOKIE['remembered_user']]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = ($user['email'] === 'admin@mail.ru' && password_verify('111', $user['password']))
            ? 'admin'
            : 'user';
    } else {
        setcookie("remembered_user", "", time() - 3600, "/");
    }
}

