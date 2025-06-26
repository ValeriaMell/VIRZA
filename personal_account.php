<?php
require_once 'session_restore.php';
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: authorization.php');
    exit;
}

if ($_SESSION['user_role'] === 'admin') {
    header('Location: admin_panel.php');
    exit;
}

$userId = $_SESSION['user_id'];

// Получаем данные пользователя
$stmt = $pdo->prepare("SELECT email FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

// Получаем отзывы
$reviewStmt = $pdo->prepare("SELECT r.text, r.rating, g.title AS game_name FROM reviews r JOIN games g ON r.game_id = g.id WHERE r.user_id = ?");
$reviewStmt->execute([$userId]);
$reviews = $reviewStmt->fetchAll();

// Получаем резюме
$resumeStmt = $pdo->prepare("SELECT position_applied FROM resumes WHERE user_id = ?");
$resumeStmt->execute([$userId]);
$resume = $resumeStmt->fetch();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="presonal_account_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&family=Ubuntu:wght@700&family=Varela&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <a href="main.php" class="logo-link"><img src="img/logo.png" alt="logo"></a>
    <div class="menu">
        <a href="main.php">Главная</a>
        <div class="dropdown">
            <button class="dropbtn">Игры</button>
            <div class="dropdown_content">
                <a href="firefly_dance.php">Танец Светлячков</a>
                <a href="star_rift.php">Звездный разлом</a>
                <a href="born_from_ashes.php">Рожденный из пепла</a>
            </div>
        </div>
        <a href="company.php">Компания</a>
        <a href="news.php">Новости</a>
    </div>
    <div class="avatar-menu">
        <img src="img/avatar.png" alt="avatar">
        <div class="avatar-dropdown">
            <a href="personal_account.php">Личный кабинет</a>
            <a href="logout.php">Выход</a>
        </div>
    </div>
</header>

<main class="account-container">
    <section class="profile-box">
        <img src="img/avatar2.png" alt="Avatar" class="profile-avatar">
        <div class="profile-info">
            <div class="nickname"><?= htmlspecialchars($user['email']) ?></div>
        </div>
        <a href="logout.php" class="logout-button">Выйти</a>
    </section>

    <section class="welcome-section">
        <h2>Добро пожаловать!</h2>

        <?php if ($resume): ?>
            <p class="resume-status">Ваше резюме на вакансию <strong><?= htmlspecialchars($resume['position_applied']) ?></strong> в рассмотрении. Скоро мы с вами свяжемся.</p>
        <?php endif; ?>

        <?php if ($reviews): ?>
            <h3>Ваши отзывы:</h3>
            <ul class="user-reviews">
                <?php foreach ($reviews as $review): ?>
                    <li>
                        <strong><?= htmlspecialchars($review['game_name']) ?>:</strong>
                        <span class="rating">Оценка: <?= $review['rating'] ?>/10</span>
                        <p><?= htmlspecialchars($review['text']) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Вы пока не оставили отзывов.</p>
        <?php endif; ?>
    </section>
</main>

<footer>
    <a href="main.php" class="logo-link"><img src="img/logo.png" alt="logo"></a>
    <div class="menu">
        <a href="main.php">Главная</a>
        <div class="dropdown">
            <button class="dropbtn">Игры</button>
            <div class="dropdown_content_footer">
                <a href="firefly_dance.php">Танец Светлячков</a>
                <a href="star_rift.php">Звездный разлом</a>
                <a href="born_from_ashes.php">Рожденный из пепла</a>
            </div>
        </div>
        <a href="company.php">Компания</a>
        <a href="news.php">Новости</a>
    </div>
    <div class="social_networks">
        <a href="#"><img src="img/tiktok.png" width="40" height="40" alt="tiktok"></a>
        <a href="#"><img src="img/tg.png" width="40" height="38" alt="telegram"></a>
        <a href="#"><img src="img/vk.png" width="40" height="38" alt="vk"></a>
    </div>
</footer>

</body>
</html>
