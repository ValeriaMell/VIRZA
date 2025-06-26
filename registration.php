<?php
session_start();
require_once 'db.php';

$name = '';
$email = '';
$errors = [];
$fieldErrors = [
    'name' => '',
    'email' => '',
    'password' => '',
    'confirm_password' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    $remember = isset($_POST['remember_me']);

    // Проверка на пустые поля и правила
    if ($name === '') {
        $fieldErrors['name'] = "Введите логин";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/u', $name)) {
        $fieldErrors['name'] = "Логин может содержать только латинские буквы и цифры без пробелов";
    }

    if ($email === '') {
        $fieldErrors['email'] = "Введите email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $fieldErrors['email'] = "Некорректный email";
    }

    if ($password === '') {
        $fieldErrors['password'] = "Введите пароль";
    } elseif (strlen($password) < 6) {
        $fieldErrors['password'] = "Пароль должен быть не менее 6 символов";
    }

    if ($confirm === '') {
        $fieldErrors['confirm_password'] = "Повторите пароль";
    } elseif ($password !== $confirm) {
        $fieldErrors['confirm_password'] = "Пароли не совпадают";
    }

    // Если ошибок нет — регистрация
    if (!array_filter($fieldErrors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $fieldErrors['email'] = "Такой email уже зарегистрирован";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hashed]);

            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_name'] = $name;
            $_SESSION['user_role'] = 'user';

            if ($remember) {
                setcookie("remembered_user", $email, time() + 3600 * 24 * 30);
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
  <link rel="stylesheet" href="registration_style.css">
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
  <div class="auth-wrapper">
    <h2>Регистрация</h2>
    <form method="POST" novalidate>
      <input type="text" name="name" placeholder="Логин" required value="<?= htmlspecialchars($name) ?>"><br>
      <?php if ($fieldErrors['name']): ?>
        <div class="form-errors" style="color:red; margin-top:10px;"><?= $fieldErrors['name'] ?></div>
      <?php endif; ?>
      <br>

      <input type="email" name="email" placeholder="Почта" required value="<?= htmlspecialchars($email) ?>"><br>
      <?php if ($fieldErrors['email']): ?>
        <div class="form-errors" style="color:red; margin-top:10px;"><?= $fieldErrors['email'] ?></div>
      <?php endif; ?>
      <br>

      <input type="password" name="password" placeholder="Пароль" required><br>
      <?php if ($fieldErrors['password']): ?>
        <div class="form-errors" style="color:red; margin-top:10px;"><?= $fieldErrors['password'] ?></div>
      <?php endif; ?>
      <br>

      <input type="password" name="confirm_password" placeholder="Повторите пароль" required><br>
      <?php if ($fieldErrors['confirm_password']): ?>
        <div class="form-errors" style="color:red; margin-top:10px;"><?= $fieldErrors['confirm_password'] ?></div>
      <?php endif; ?>
      <br>

      <div class="auth-options">
        <label class="remember-me">
          <input type="checkbox" name="remember_me" <?= isset($_POST['remember_me']) ? 'checked' : '' ?>> Запомнить меня
        </label>
      </div>

      <button type="submit">Зарегистрироваться</button>
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


