<?php require_once 'session_restore.php'; ?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIRZA</title>
    <link rel="stylesheet" href="main_style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Varela&display=swap" rel="stylesheet">
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

        <section class="slider">
            <div class="slide active">
                <img src="img/main/main_picture.png" alt="Game 1">
                <div class="slide-content">
                <h2>Танец <br> Светлячков</h2>
                <a href="firefly_dance.php" class="play-btn">Играть</a>
                </div>
            </div>
            <div class="slide">
                <img src="img/star_rift.jpeg" alt="Game 2">
                <div class="slide-content">
                <h2>Звёздный <br> Разлом</h2>
                <a href="star_rift.php" class="play-btn">Играть</a>
                </div>
            </div>
            <div class="slide">
                <img src="img/born_from_ashes_main_pic.jpeg" alt="Game 3">
                <div class="slide-content">
                <h2>Рождённый <br> Из Пепла</h2>
                <a href="born_from_ashes.php" class="play-btn">Играть</a>
                </div>
            </div>

            <button class="arrow left">&#10094;</button>
            <button class="arrow right">&#10095;</button>
        </section>

    
    <div class="about_us">
        <div class="text_about_us">
            <h3>О нас</h3>
            <p>
                VIRZA — независимая студия, создающая игры в разных жанрах для самых разных игроков. <br><br>
                Мы любим эксперименты, ценим атмосферу и всегда стремимся к качеству. <br><br>
                От динамичных приключений до глубоких историй — наши проекты рождаются из идей, которыми хочется делиться.
            </p>
            <a href="company.php" class="follow_the_link">Перейти</a>
        </div>
        <div class="photo_about_us">
            <img src="img/main/about_us_home.png" alt="photo_about_us" width="627" height="627">
        </div>
    </div>

    <div class="news">
        <h3>Новости</h3>

        <div class="all_box_news">
            <div class="box_news">
                <img src="img/main/firefly_dance.png" alt="firefly_dance_news" width="383">
                <div class="content_news">
                    <button>Игровые новости</button>
                    <h4>Танец Светлячков</h4>
                    <p>
                        Новые головоломки, атмосферные сцены и улучшенные визуальные эффекты леса.
                    </p>
                    <a href="news.php" class="read_btn">Читать</a>
                </div>
            </div>

            <div class="box_news">
                <img src="img/main/residual_signal.png" alt="firefly_dance_news" width="383">
                <div class="content_news">
                    <button class="btn_announcements">Анонсы</button>
                    <h4>Остаточный сигнал</h4>
                    <p>
                        Последний отклик забытой сети. <br>
                        Тени мегаполиса хранят то, что нельзя было передавать.
                    </p>
                    <a href="news.php" class="read_btn">Читать</a>
                </div>
            </div>

            <div class="box_news">
                <img src="img/main/sands_of_vergis.png" alt="firefly_dance_news" width="383">
                <div class="content_news">
                    <button>Игровые новости</button>
                    <h4>Рожденный из пепла</h4>
                    <p>
                        Глубокий анализ мифологии мира от разработчиков. <br><br>
                    </p>
                    <a href="news.php" class="read_btn">Читать</a>
                </div>
            </div>
        </div>        
    </div>

    <div class="contacts">
        <h3>Контакты</h3>

        <div class="content_contacts">
            <div class="map">
                <div style="position:relative;overflow:hidden;"><a href="https://yandex.ru/maps/213/moscow/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Москва</a><a href="https://yandex.ru/maps/213/moscow/house/bolshoy_spasoglinishchevskiy_pereulok_3s5/Z04YcARlSEwAQFtvfXt0d3hgYw==/?ll=37.635197%2C55.756437&utm_medium=mapframe&utm_source=maps&z=16" style="color:#eee;font-size:12px;position:absolute;top:14px;">Большой Спасоглинищевский переулок, 3с5 на карте Москвы, ближайшее метро Китай-город — Яндекс Карты</a><iframe src="https://yandex.ru/map-widget/v1/?ll=37.635197%2C55.756437&mode=whatshere&whatshere%5Bpo…17&z=16" width="500" height="500" style="border: none; position: relative;" allowfullscreen></iframe></div>
            </div>
            <div class="text_contacts">
                <h5>Адрес:</h5>
                <p>Большой Спасоглинищевский пер., 5/4 строение 5, Москва, 101000</p>

                <h5>Часы работы:</h5>
                <p>Пн-Пт 9:00 - 19:00</p>

                <h5>Почта:</h5>
                <p>virza_game@mail.ru</p>

                <h5>Телефон:</h5>
                <p>8 (920) 809 56 30</p>
            </div>
        </div>
    </div>

    <div class="partners">
        <h3>Партнеры</h3>
        <div class="logo_partners">
            <img src="img/main/logo1.png" width="176" height="176" alt="logo_partners1" class="logo_partners1">
            <img src="img/main/logo2.png" width="172" height="171" alt="logo_partners2" class="logo_partners2">
            <img src="img/main/logo3.png" width="121" height="120" alt="logo_partners3" class="logo_partners3">
            <img src="img/main/logo4.png" width="134" height="113" alt="logo_partners4" class="logo_partners4">
            <img src="img/main/logo5.png" width="132" height="132" alt="logo_partners5" class="logo_partners5">
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
            <a href="https://www.tiktok.com/@annmilan.bc?is_from_webapp=1&sender_device=pc"><img src="img/tiktok.png" width="40" height="40" alt="tiktok"></a>
            <a href="https://t.me/dobromoscow"><img src="img/tg.png" width="40" height="38" alt="telegram"></a>
            <a href="https://vk.com/versportaa?from=groups"><img src="img/vk.png" width="40" height="38" alt="vk"></a>
        </div>

    </footer>

<script src="script.js"></script>
</body>
</html>
