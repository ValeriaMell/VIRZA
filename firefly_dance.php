<?php session_start(); ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIRZA</title>
    <link rel="stylesheet" href="firefly_dance_style.css">
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

    <section class="full-screen-image">
        <h2 class="headline">Танец <br> Светлячков</h2>
    </section>

    <div class="game_description">
        <div class="text_description">
            <h3>Свет, что ведет через тьму</h3>
            <p>
                Мальчик по имени Лио просыпается в таинственном лесу, где единственный путь — за светом маленьких светлячков.Это атмосферное приключение погружает в мир теней, забытых голосов и световых загадок, где каждое движение — шаг к истине. Исследуй живые пейзажи, решай головоломки и раскрой историю, спрятанную в темноте.
            </p>
        </div>
        <div class="gallery">
            <img src="img/firefly_dance/pic_2.png" width="310" height="402" alt="photo_from_the_game">
            <img src="img/firefly_dance/pic_1.png" width="310" height="402" alt="photo_from_the_game">
            <img src="img/firefly_dance/pic_3.png" width="310" height="402" alt="photo_from_the_game">
        </div>

        <div class="container_btn">
            <a href="download_file.pdf" class="download_btn" download>Скачать</a>
        </div>
    </div>

    <h3>Характеристики</h3>
    <div class="all_characteristics">
            <div class="characteristics">
            <h4>Основная информация об игре</h4>
            <p>
                Жанр: Атмосферное приключение  Платформер  Головоломка <br>
                Стиль: Медитативная, визуальная история без слов <br>
                Продолжительность: 1–2 часа <br>
                Особенности: Световые загадки, эмоциональный сюжет, нарратив через окружение <br>
                Возрастной рейтинг: <strong>10+</strong>
            </p>
        </div>

        <div class="language_and_platform_block">
            <div class="characteristics_language">
                <h4>Языки и доступность</h4>
                <p>
                    Языки интерфейса: Русский, Английский <br>
                    Субтитры: Не требуются — повествование без текста <br>
                    Доступность: Высокий визуальный контраст, минималистичный интерфейс
                </p>
            </div>

            <div class="characteristics_platform">
                <h4>Платформы и управление</h4>
                <p>
                    Платформы: Windows / macOS <br>
                    Управление: Клавиатура  Геймпад
                </p>
            </div>
        </div>

        <div class="requirements_and_information_block">
            <div class="characteristics_requirements">
                <h4>Минимальные системные требования</h4>
                <p>
                    ОС: Windows 10 (64-bit) или macOS 10.14 и выше <br>
                    Процессор: Intel Core i3-6100 / AMD Ryzen 3 1200 или лучше <br>
                    Оперативная память: 4 ГБ RAM <br>
                    Видеокарта: NVIDIA GeForce GTX 650 / AMD Radeon HD 7750 или <br> интегрированная графика с поддержкой DirectX 11 <br>
                    Место на диске: 3 ГБ свободного пространства
                </p>
            </div>

            <div class="characteristics_information">
                <h4>Техническая информация</h4>
                <p>
                    Разработчик: VIRZA <br> Движок: Unity <br> Разрешение: Поддержка от HD до 4K
                </p>
            </div>
        </div>
    </div>
    
    <h3>Отзывы</h3>
    <div class="two_review">
        <div class="review">
            <img src="img/avatar2.png" width="100" height="100" alt="avatar" class="avatar">
            <div class="text_review">
                <h4>KitsuRay</h4>
                <p>
                    <small>10.03.2025</small> <br>
                    Очень необычная подача истории, визуальный <br>
                    стиль запоминается сразу. Иногда было темновато, <br>
                    но в целом — впечатления сильные. <br> <br>

                    Оценка 9/10
                </p>
            </div>
        </div>

        <div class="review">
            <img src="img/avatar2.png" width="100" height="100" alt="avatar" class="avatar">
            <div class="text_review">
                <h4>MemoryDrift</h4>
                <p>
                    <small>20.05.2025</small> <br>
                    Визуал, звук и общее чувство уединения создают <br>
                    по-настоящему глубокий опыт. Тревожно и красиво <br>
                    одновременно. <br><br>

                    Оценка 10/10
                </p>
            </div>
        </div>
    </div>

    <div class="two_review">
        <div class="review">
            <img src="img/avatar2.png" width="100" height="100" alt="avatar" class="avatar">
            <div class="text_review">
                <h4>Owl_Night</h4>
                <p>
                    <small>05.06.2025</small> <br>
                    Игра оставляет яркое впечатление благодаря <br>
                    атмосферным светлячкам, выразительному визуальному
                    стилю и сильному финалу, а <br>
                    единственное, чего действительно не хватает — это <br>
                    ещё большего количества уровней <br><br>

                    Оценка 10/10
                </p>
            </div>
        </div>

        <div class="review">
            <img src="img/avatar2.png" width="100" height="100" alt="avatar" class="avatar">
            <div class="text_review">
                <h4>LumenFox</h4>
                <p>
                    <small>30.05.2025</small> <br>
                    Невероятно трогательная история без единого <br>
                    слова. Свет и тени тут — отдельные герои. Пожалуй, <br>
                    одна из самых эмоциональных инди-игр, в которые <br>
                    я играл. <br><br>

                    Оценка 10/10
                </p>
            </div>
        </div>
    </div>

    <div class="review_form">
        <div class="form-wrapper">
            <h2>Оставьте отзыв</h2>
            <form id="reviewForm" novalidate>
            <input type="text" name="username" placeholder="Имя">
            <div class="error-message" data-error-for="username"></div>

            <select name="rating">
                <option value="" disabled selected>Оценка</option>
                <option>1</option><option>2</option><option>3</option><option>4</option><option>5</option>
                <option>6</option><option>7</option><option>8</option><option>9</option><option>10</option>
            </select>
            <div class="error-message" data-error-for="rating"></div>

            <textarea name="text" placeholder="Сообщение"></textarea>
            <div class="error-message" data-error-for="text"></div>

            <button type="submit">Отправить</button>
            <div id="reviewSuccess" style="color: #E6E6EA; text-align: center; margin-top: 20px;"></div>
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
                <a href="https://www.tiktok.com/@annmilan.bc?is_from_webapp=1&sender_device=pc"><img src="img/tiktok.png" width="40" height="40" alt="tiktok"></a>
                <a href="https://t.me/dobromoscow"><img src="img/tg.png" width="40" height="38" alt="telegram"></a>
                <a href="https://vk.com/versportaa?from=groups"><img src="img/vk.png" width="40" height="38" alt="vk"></a>
            </div>

        </footer>

<script>
document.getElementById('reviewForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);
  const successDiv = document.getElementById('reviewSuccess');

  // Очистка предыдущих сообщений
  successDiv.textContent = '';
  document.querySelectorAll('.error-message').forEach(div => div.textContent = '');

  const username = form.username.value.trim();
  const rating = form.rating.value;
  const text = form.text.value.trim();

  let hasError = false;

  if (username === '') {
    document.querySelector('[data-error-for="username"]').textContent = 'Пожалуйста, введите имя';
    hasError = true;
  }

  if (rating === '') {
    document.querySelector('[data-error-for="rating"]').textContent = 'Пожалуйста, выберите оценку';
    hasError = true;
  }

  if (text === '') {
    document.querySelector('[data-error-for="text"]').textContent = 'Пожалуйста, введите сообщение';
    hasError = true;
  }

  if (hasError) return;

  formData.append('game_id', 1); // ID игры

  fetch('submit_review.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      successDiv.textContent = 'Спасибо за отзыв!';
      form.reset();
    } else if (data.errorType === 'auth') {
      successDiv.textContent = 'Чтобы оставить отзыв, войдите в аккаунт.';
    } else if (data.errors) {
      for (const field in data.errors) {
        const fieldError = document.querySelector(`.error-message[data-error-for="${field}"]`);
        if (fieldError) fieldError.textContent = data.errors[field];
      }
    } else {
      successDiv.textContent = 'Произошла ошибка. Попробуйте позже.';
    }
  })
  .catch(() => {
    successDiv.textContent = 'Ошибка соединения с сервером.';
  });
});

// Снимаем ошибку при вводе
document.querySelectorAll('#reviewForm input, #reviewForm select, #reviewForm textarea').forEach(input => {
  input.addEventListener('input', () => {
    const errorDiv = document.querySelector(`.error-message[data-error-for="${input.name}"]`);
    if (errorDiv) errorDiv.textContent = '';
  });
});
</script>


</body>
</html>