<?php
require_once 'session_restore.php';
require_once 'db.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $position = trim($_POST['position']);

    // Проверка авторизации
    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
        echo json_encode(['success' => false, 'errors' => ['auth' => 'Авторизуйтесь, чтобы отправить резюме.']]);
        exit;
    }

    // Валидация
    if (empty($firstName) || !preg_match("/^[А-Яа-яA-Za-z\s-]+$/u", $firstName)) {
        $errors['first_name'] = 'Введите корректное имя';
    }
    if (empty($lastName) || !preg_match("/^[А-Яа-яA-Za-z\s-]+$/u", $lastName)) {
        $errors['last_name'] = 'Введите корректную фамилию';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите корректный email';
    }
    if (empty($phone) || !preg_match("/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/", $phone)) {
        $errors['phone'] = 'Введите телефон в формате +7 (000) 000-00-00';
    }
    if (empty($position)) {
        $errors['position'] = 'Выберите вакансию';
    }
    if (!isset($_FILES['resume']) || $_FILES['resume']['error'] !== UPLOAD_ERR_OK) {
        $errors['resume'] = 'Загрузите файл резюме';
    } elseif (pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION) !== 'pdf') {
        $errors['resume'] = 'Файл должен быть в формате PDF';
    }

    if (empty($errors)) {
        $fileName = time() . '_' . basename($_FILES['resume']['name']);
        $targetDir = __DIR__ . '/uploads/resumes/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $targetPath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['resume']['tmp_name'], $targetPath)) {
            $stmt = $pdo->prepare("INSERT INTO resumes (user_id, first_name, last_name, email, phone, position_applied, resume_file, uploaded_at)
                                   VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([
                $userId,
                $firstName,
                $lastName,
                $email,
                $phone,
                $position,
                $fileName
            ]);

            echo json_encode(['success' => true]);
            exit;
        } else {
            $errors['resume'] = 'Ошибка при сохранении файла';
        }
    }

    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>VIRZA - Компания</title>
    <link rel="stylesheet" href="conpany_style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Varela&display=swap"
      rel="stylesheet"
    />
</head>
<body>
    <header>
        <a href="main.php" class="logo-link"><img src="img/logo.png" width="54" height="89" alt="logo" /></a>
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
            <img src="img/avatar.png" width="61" height="63" alt="avatar" />
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

    <div class="company_description">
        <div class="text_description">
            <h2>Внесите свою <br /> лепту в игру</h2>
            <p>
                Компания VIRZA — студия, специализирующаяся на разработке
                видеоигр различных жанров. С момента своего основания
                VIRZA стремится создавать уникальные игровые миры,
                предлагая игрокам захватывающий геймплей и глубокие сюжеты. <br /><br />
                Наша команда состоит из талантливых разработчиков,
                дизайнеров и художников, объединённых общей целью —
                дарить игрокам незабываемые впечатления.
            </p>
        </div>
        <div class="photo_company">
            <img
              src="img/career/main_pic.png"
              width="631"
              height="630"
              alt="photo_company"
            />
        </div>
    </div>

    <h2>Наши достоинства</h2>
    <div class="our_virtues">
        <div class="block_virtues">
            <img
              src="img/career/dignity1.png"
              width="368"
              height="330"
              alt="virtues_photo"
            />
            <h3>Рост компетенции</h3>
            <p>
                VIRZA поддерживает стремление
                сотрудников к росту, предоставляя
                доступ к обучающим материалам,
                курсам и участию в профильных
                конференциях
            </p>
        </div>

        <div class="block_virtues">
            <img
              src="img/career/dignity2.png"
              width="368"
              height="330"
              alt="virtues_photo"
            />
            <h3>Творческая свобода</h3>
            <p>
                Каждый сотрудник имеет <br />
                возможность вносить свои идеи и <br />
                участвовать в разработке проектов с <br />
                самого начала.
            </p>
        </div>

        <div class="block_virtues">
            <img
              src="img/career/dignity3.png"
              width="368"
              height="330"
              alt="virtues_photo"
            />
            <h3>Гибкий график</h3>
            <p>
                Компания предлагает гибкие условия труда, включая возможность работать удалённо, что позволяет сотрудникам сохранять баланс между работой и личной жизнью
            </p>
        </div>
    </div>

    <h2>Вакансии</h2>

    <div class="all_vacancy">
        <div class="city" onclick="toggleCity(this)">
            <div class="city-header">
                <span>Москва</span>
                <span class="arrow">&#8595;</span>
            </div>
            <div class="vacancies" style="display:none;">
                <div class="vacancy">
                    <h4>Frontend-разработчик</h4>
                    <p>Разработка интерфейсов на React</p>
                    <p>Опыт: от 2 лет</p>
                    <p>Зарплата: 120 000 ₽</p>
                </div>
                <div class="vacancy">
                    <h4>Менеджер проектов</h4>
                    <p>Управление IT-проектами</p>
                    <p>Опыт: от 3 лет</p>
                    <p>Зарплата: 150 000 ₽</p>
                </div>
            </div>
        </div>

        <div class="city" onclick="toggleCity(this)">
            <div class="city-header">
                <span>Санкт-Петербург</span>
                <span class="arrow">&#8595;</span>
            </div>
            <div class="vacancies" style="display:none;">
                <div class="vacancy">
                    <h4>UX/UI дизайнер</h4>
                    <p>Создание дизайна для веб-приложений</p>
                    <p>Опыт: от 1 года</p>
                    <p>Зарплата: 100 000 ₽</p>
                </div>
                <div class="vacancy">
                    <h4>Тестировщик</h4>
                    <p>Проверка функциональности приложений</p>
                    <p>Опыт: от 2 лет</p>
                    <p>Зарплата: 90 000 ₽</p>
                </div>
                <div class="vacancy">
                    <h4>Аналитик данных</h4>
                    <p>Анализ пользовательских данных</p>
                    <p>Опыт: от 2 лет</p>
                    <p>Зарплата: 110 000 ₽</p>
                </div>
            </div>
        </div>

        <div class="city" onclick="toggleCity(this)">
            <div class="city-header">
                <span>Казань</span>
                <span class="arrow">&#8595;</span>
            </div>
            <div class="vacancies" style="display:none;">
                <div class="vacancy">
                    <h4>Системный администратор</h4>
                    <p>Поддержка IT-инфраструктуры</p>
                    <p>Опыт: от 3 лет</p>
                    <p>Зарплата: 100 000 ₽</p>
                </div>
                <div class="vacancy">
                    <h4>Контент-менеджер</h4>
                    <p>Управление контентом на сайте</p>
                    <p>Опыт: от 1 года</p>
                    <p>Зарплата: 80 000 ₽</p>
                </div>
            </div>
        </div>
    </div>

    <h2>Стажировки</h2>

    <div class="all_vacancy">
        <div class="city" onclick="toggleCity(this)">
            <div class="city-header">
                <span>Москва</span>
                <span class="arrow">&#8595;</span>
            </div>
            <div class="vacancies" style="display:none;">
                <div class="vacancy">
                    <h4>Junior DevOps-инженер</h4>
                    <p>Настройка CI/CD, мониторинг и поддержка инфраструктуры</p>
                    <p>Опыт: без опыта / стажировка</p>
                    <p>Зарплата: 40 000 ₽</p>
                </div>
                <div class="vacancy">
                    <h4>Ассистент маркетолога</h4>
                    <p>Помощь в проведении маркетинговых кампаний и аналитике</p>
                    <p>Опыт: без опыта / стажировка</p>
                    <p>Зарплата: 35 000 ₽</p>
                </div>
            </div>
        </div>

        <div class="city" onclick="toggleCity(this)">
            <div class="city-header">
                <span>Санкт-Петербург</span>
                <span class="arrow">&#8595;</span>
            </div>
            <div class="vacancies" style="display:none;">
                <div class="vacancy">
                    <h4>Стажёр в команду поддержки</h4>
                    <p>Обработка обращений пользователей, первичная диагностика</p>
                    <p>Опыт: без опыта / стажировка</p>
                    <p>Зарплата: 30 000 ₽</p>
                </div>
                <div class="vacancy">
                    <h4>Junior Motion-дизайнер</h4>
                    <p>Создание анимаций для социальных сетей и презентаций</p>
                    <p>Опыт: от 3 месяцев (фриланс/учёба)</p>
                    <p>Зарплата: 45 000 ₽</p>
                </div>
            </div>
        </div>

        <div class="city" onclick="toggleCity(this)">
            <div class="city-header">
                <span>Казань</span>
                <span class="arrow">&#8595;</span>
            </div>
            <div class="vacancies" style="display:none;">
                <div class="vacancy">
                    <h4>Ассистент системного аналитика</h4>
                    <p>Сбор и описание требований, работа с документацией</p>
                    <p>Опыт: без опыта / стажировка</p>
                    <p>Зарплата: 38 000 ₽</p>
                </div>
                <div class="vacancy">
                    <h4>Стажёр-копирайтер</h4>
                    <p>Написание текстов для сайта и соцсетей</p>
                    <p>Опыт: от 1 месяца (учёба / портфолио)</p>
                    <p>Зарплата: 25 000 ₽</p>
                </div>
            </div>
        </div>
    </div>

    <div class="form_vacancy">
        <div class="form-wrapper">
            <h2>Оставьте заявку</h2>
                <form id="vacancyForm" action="" method="post" enctype="multipart/form-data" novalidate>
                    <input type="text" name="first_name" placeholder="Имя" required>
                    <div class="error-message"></div>

                    <input type="text" name="last_name" placeholder="Фамилия" required>
                    <div class="error-message"></div>

                    <input type="email" name="email" placeholder="Почта" required>
                    <div class="error-message"></div>

                    <input type="tel" name="phone" placeholder="Телефон" required>
                    <div class="error-message"></div>

                    <select name="position" required>
                        <option value="" disabled selected>Вакансия</option>
                        <option>Frontend-разработчик</option>
                        <option>Менеджер проектов</option>
                        <option>UX/UI дизайнер</option>
                        <option>Тестировщик</option>
                        <option>Аналитик данных</option>
                        <option>Системный администратор</option>
                        <option>Контент-менеджер</option>
                        <option>Junior DevOps-инженер</option>
                        <option>Ассистент маркетолога</option>
                        <option>Стажёр в команду поддержки</option>
                        <option>Junior Motion-дизайнер</option>
                        <option>Ассистент системного аналитика</option>
                        <option>Стажёр-копирайтер</option>
                    </select>
                    <div class="error-message"></div>

                    <div class="resume-upload">
                        <label for="resume" class="file-label">Выберите файл (PDF)</label>
                        <input type="file" name="resume" id="resume" accept=".pdf" required>
                        <span class="file-name" id="file-name">Файл не выбран</span>
                        <div class="error-message"></div>
                    </div>

                    <div id="formSuccess" style="color: green; text-align: center; margin-top: 10px;"></div>

                    <button type="submit">Отправить</button>
                </form>
        </div>
    </div>

    <footer>
        <a href="main.php" class="logo-link"><img src="img/logo.png" width="54" height="89" alt="logo" /></a>
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
            <a href="https://www.tiktok.com/@annmilan.bc?is_from_webapp=1&sender_device=pc"
                ><img src="img/tiktok.png" width="40" height="40" alt="tiktok"
            /></a>
            <a href="https://t.me/dobromoscow"
                ><img src="img/tg.png" width="40" height="38" alt="telegram"
            /></a>
            <a href="https://vk.com/versportaa?from=groups"
                ><img src="img/vk.png" width="40" height="38" alt="vk"
            /></a>
        </div>
    </footer>

    <script src="https://unpkg.com/imask"></script>
    <script src="company_script.js"></script>
</body>
</html>
