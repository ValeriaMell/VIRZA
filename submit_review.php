<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Вы не авторизованы',
        'errorType' => 'auth'
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];
$game_id = (int)$_POST['game_id'];
$username = trim($_POST['username']);
$text = trim($_POST['text']);
$rating = (int)$_POST['rating'];

$errors = [];

if ($username === '') $errors['username'] = 'Введите имя';
if ($rating < 1 || $rating > 10) $errors['rating'] = 'Выберите оценку от 1 до 10';
if ($text === '') $errors['text'] = 'Введите сообщение';

if (!empty($errors)) {
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO reviews (user_id, game_id, text, rating, created_at, is_visible, is_edited) VALUES (?, ?, ?, ?, CURDATE(), 0, 0)");
    $stmt->execute([$user_id, $game_id, $text, $rating]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка БД']);
}
?>
