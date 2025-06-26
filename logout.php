<?php
session_start();

// Очистка данных сессии
$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}

// Удаление сессии
session_destroy();

// Удаление куки "remembered_user" — ОБЯЗАТЕЛЬНО с путём "/"
setcookie("remembered_user", "", time() - 3600, "/");

header("Location: main.php");
exit;

