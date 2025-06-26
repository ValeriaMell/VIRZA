# Веб-приложение для копании по разработке игр VIRZA

## Технологии
- Backend: PHP 7+, PDO
- База данных: MySQL (phpMyAdmin)
- Frontend: HTML, CSS, JavaScript
- Контроль версий: Git + GitHub

## Установка
1. клонировать репозиторий
    git clone https://github.com/VIRZA/game-company.git
2. Разместить папку проекта в директории веб-сервера (например: htdocs/virza или www/virza)
3. Запустить phpMyAdmin через панель управления (OpenServer/XAMPP)

## Настройка базы данных
1. Открыть phpMyAdmin в браузере
2. Создать новую БД с именем game_company_db
3. Перейти во вкладку "Импорт"
4. Выбрать файл virza_db.sql из корня проекта
5. Нажать "ОК" для запуска импорта

## Конфигурация
Проверить настройки подключения в php/db_connect.php:
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'game_company_db');
define('DB_USER', 'root');
define('DB_PASS', 'root');
?>

## Запуск
1. Запустить веб-сервер и MySQL через:
        OpenServer: "Запуск" - модули Apache+MySQL
        XAMPP: Start для Apache и MySQL
2. Открыть в браузере: http://localhost/virza

## Техническая поддержка
При ошибках подключения к БД:
1. Проверить запущен ли MySQL
2. Убедиться в правильности логина/пароля в db_connect.php
3. Проверить наличие БД game_company_db в phpMyAdmin
4. Убедиться, что файл virza_db.sql был успешно импортирован

