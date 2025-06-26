<?php
session_start();
require_once 'db.php';

$email = '';
$errors = [
    'email' => '',
    'password' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember_me']);

    if (empty($email)) {
        $errors['email'] = "Поле email не должно быть пустым";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Неверный формат email";
    }

    if (empty($password)) {
        $errors['password'] = "Поле пароль не должно быть пустым";
    }

    if (empty($errors['email']) && empty($errors['password'])) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            $errors['email'] = "Пользователь с таким email не найден";
        } elseif (!password_verify($password, $user['password'])) {
            $errors['password'] = "Неверный пароль";
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            // определяем роль
            $_SESSION['user_role'] = ($email === 'admin@mail.ru' && password_verify('111', $user['password']))
                ? 'admin'
                : 'user';

            if ($remember) {
                setcookie("remembered_user", $email, time() + 3600 * 24 * 30, "/");
            }

            header("Location: personal_account.php");
            exit;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>VIRZA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="authorization_style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;800&family=Ubuntu&family=Varela&display=swap" rel="stylesheet">
</head>
<body>

<header>
  <a href="main.php" class="logo-link"><img src="img/logo.png" width="54" height="89" alt="logo"></a>
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
    <img src="img/avatar.png" width="61" height="63" alt="avatar">
    <div class="avatar-dropdown">
        <?php if (isset($_SESSION['user_id'])): ?>
        <?php if ($_SESSION['user_role'] === 'admin'): ?>
            <a href="admin_panel.php">Админ-панель</a>
        <?php else: ?>
            <a href="personal_account.php">Личный кабинет</a>
        <?php endif; ?>
        <a href="logout.php">Выход</a>
        <?php else: ?>
        <a href="authorization.php">Вход</a>
        <a href="registration.php">Регистрация</a>
        <?php endif; ?>
    </div>
  </div>
</header>

<div class="form_auth">
  <div class="auth-wrapper" style="height: auto;">
    <h2>Авторизация</h2>
    <form method="POST" novalidate>
      <input type="email" name="email" placeholder="Почта" required value="<?= htmlspecialchars($email) ?>">
      <?php if ($errors['email']): ?>
        <div class="form-errors" style="color:red; margin: 10px 0; font-size: 14px; text-align: center;">
          <?= $errors['email'] ?>
        </div>
      <?php endif; ?>

      <input type="password" name="password" placeholder="Пароль" required>
      <?php if ($errors['password']): ?>
        <div class="form-errors" style="color:red; margin: 10px 0; font-size: 14px; text-align: center;">
          <?= $errors['password'] ?>
        </div>
      <?php endif; ?>

      <div class="auth-options">
        <a href="#" class="forgot-password">Забыли пароль?</a>
        <label class="remember-me">
          <input type="checkbox" name="remember_me" <?= isset($_POST['remember_me']) ? 'checked' : '' ?>> Запомнить меня
        </label>
      </div>

      <button type="submit">Авторизоваться</button>
    </form>
  </div>
</div>

<footer>
  <a href="main.php" class="logo-link"><img src="img/logo.png" width="54" height="89" alt="logo"></a>
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
    <a href="https://www.tiktok.com/@annmilan.bc"><img src="img/tiktok.png" width="40" height="40" alt="tiktok"></a>
    <a href="https://t.me/dobromoscow"><img src="img/tg.png" width="40" height="38" alt="telegram"></a>
    <a href="https://vk.com/versportaa"><img src="img/vk.png" width="40" height="38" alt="vk"></a>
  </div>
</footer>

</body>
</html>




