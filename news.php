<?php require_once 'session_restore.php'; ?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIRZA</title>
    <link rel="stylesheet" href="news_style.css">
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

    <h3>Новости</h3>

    <div class="all_news">

        <div class="news">
            <div class="news_box">
                <div class="photo_news">
                    <img src="img/news/firefly_dance.png" width="350" height="200" alt="news_photo">
                </div>
                <div class="text_news">
                    <h4>Танец Светлячков</h4>
                    <p>
                        Волшебный лес стал ещё живее — обновление «Танец светлячков» уже <br> доступно для всех игроков! <br>
                        Мы добавили не только визуальные улучшения, но и свежий контент,<br> который сделает путешествие Лио ещё более запоминающимся.
                    </p>
                </div>
            </div>
        </div>

        <div class="news">
            <div class="news_box">
                <div class="photo_news">
                    <img src="img/news/star_rift.png" width="350" height="200" alt="news_photo">
                </div>
                <div class="text_news">
                    <h4>Звездный Разлом</h4>
                    <p>
                        Звездный разлом официально получила поддержку пользовательских модификаций — теперь границы галактики зависят только от вашего воображения!
                    </p>
                </div>
            </div>
        </div>

        <div class="news">
            <div class="news_box">
                <div class="photo_news">
                    <img src="img/news/sands_of_vergis.png" width="350" height="200" alt="news_photo">
                </div>
                <div class="text_news">
                    <h4>Рожденный из пепла</h4>
                    <p>
                        Глубокий анализ мифологии мира Эшборн раскрывает древние легенды, ключевые события и скрытые связи между богами, проклятиями и падением цивилизаций.
                    </p>
                </div>
            </div>
        </div>

    </div>
    

     <h3 class="announcements">Анонсы</h3>

    <div class="all_news">

        <div class="news">
            <div class="news_box">
                <div class="photo_news">
                    <img src="img/news/residual_signal.png" width="350" height="200" alt="news_photo">
                </div>
                <div class="text_news">
                    <h4>Остаточный Сигнал</h4>
                    <p>
                        В мегаполисе, где каждый второй — ходячий вирус на ножках, а импланты важнее совести, выжить — значит остаться человеком хотя бы наполовину.<br>
                        Киберпсихоз распространяется как цифровая чума. Улицы пульсируют <br> неоном и насилием.
                    </p>
                </div>
            </div>
        </div>

        <div class="news">
            <div class="news_box">
                <div class="photo_news">
                    <img src="img/news/ash_of_the_wind.png" width="350" height="200" alt="news_photo">
                </div>
                <div class="text_news">
                    <h4>Пепел Ветра</h4>
                    <p>
                        Когда мужчины теряют честь, женщины поднимают сталь. <br>
                        Ты — Аканэ, последняя из рода, уничтоженного ночью огня и предательства. <br>
                        В мире, где женщине не позволено быть воином, ты идёшь наперекор <br>
                        судьбе — с клинком в руке и яростью в сердце.
                    </p>
                </div>
            </div>
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


</body>
</html>