<?php
require_once 'session_restore.php';
require_once 'db.php'; // Подключение PDO $pdo

$currentTable = $_GET['table'] ?? null;
$currentQuery = $_GET['query'] ?? null;

$tableData = [];
$tableFields = [];
$queryResult = [];
$queryFields = [];
$queryTitle = '';

if ($currentTable) {
    try {
        $stmt = $pdo->query("SELECT * FROM `$currentTable`");
        $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < $stmt->columnCount(); $i++) {
            $meta = $stmt->getColumnMeta($i);
            $tableFields[] = (object)['name' => $meta['name']];
        }
    } catch (PDOException $e) {
        $tableData = [];
        $tableFields = [];
    }
}

if ($currentQuery) {
    $queryNum = (int)$currentQuery;

    switch ($queryNum) {
        case 1:
            $query = "SELECT * FROM games ORDER BY release_year DESC";
            $queryTitle = "Список всех игр, отсортированных по году выпуска в порядке убывания";
            break;
        case 2:
            $query = "SELECT * FROM developers";
            $queryTitle = "Список всех разработчиков игр";
            break;
        case 3:
            $rating = $_GET['rating'] ?? 4;
            $query = "SELECT g.* FROM games g
                      JOIN reviews r ON g.id = r.game_id
                      GROUP BY g.id
                      HAVING AVG(r.rating) > :rating";
            $queryTitle = "Список всех игр со средней оценкой выше $rating";
            break;
        case 4:
            $year = $_GET['year'] ?? date('Y');
            $query = "SELECT * FROM games WHERE release_year = :year";
            $queryTitle = "Список всех игр, выпущенных в $year году";
            break;
        case 5:
            $price = $_GET['price'] ?? 1000;
            $query = "SELECT * FROM games WHERE price < :price";
            $queryTitle = "Список всех игр с ценой ниже $price";
            break;
        case 6:
            $genre = $_GET['genre'] ?? 'Платформер';
            $platform = $_GET['platform'] ?? 'Windows';
            $query = "SELECT * FROM games WHERE genre = :genre AND platforms LIKE :platform";
            $queryTitle = "Список всех игр жанра $genre для платформы $platform";
            break;
        case 7:
            $query = "SELECT genre, COUNT(*) as game_count FROM games GROUP BY genre";
            $queryTitle = "Список общего количества игр в каждом жанре";
            break;
        case 8:
            $developer = $_GET['developer'] ?? 1;
            $query = "SELECT g.* FROM games g WHERE g.developer_id = :developer";
            $queryTitle = "Список всех игр, выпущенных разработчиком с ID $developer";
            break;
        case 9:
            $minRating = $_GET['min_rating'] ?? 1;
            $maxRating = $_GET['max_rating'] ?? 10;
            $query = "SELECT g.*, AVG(r.rating) AS avg_rating
                    FROM games g
                    JOIN reviews r ON g.id = r.game_id
                    GROUP BY g.id
                    HAVING avg_rating BETWEEN :minRating AND :maxRating";
            $queryTitle = "Список игр со средней оценкой от $minRating до $maxRating";
            break;
        case 10:
            $stock = $_GET['stock'] ?? 100000;
            $query = "SELECT * FROM games WHERE stock < :stock";
            $queryTitle = "Список игр с остатком на складе меньше $stock";
            break;
        default:
            $query = null;
            $queryTitle = '';
            break;
    }

    if ($query) {
        try {
            $stmt = $pdo->prepare($query);

            switch ($queryNum) {
                case 3:
                    $stmt->bindValue(':rating', $rating);
                    break;
                case 4:
                    $stmt->bindValue(':year', $year);
                    break;
                case 5:
                    $stmt->bindValue(':price', $price);
                    break;
                case 6:
                    $stmt->bindValue(':genre', $genre);
                    $stmt->bindValue(':platform', "%$platform%");
                    break;
                case 8:
                    $stmt->bindValue(':developer', $developer);
                    break;
                case 9:
                    $stmt->bindValue(':minRating', $minRating);
                    $stmt->bindValue(':maxRating', $maxRating);
                    break;
                case 10:
                    $stmt->bindValue(':stock', $stock);
                    break;
            }

            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

            for ($i = 0; $i < $stmt->columnCount(); $i++) {
                $meta = $stmt->getColumnMeta($i);
                $queryFields[] = (object)['name' => $meta['name']];
            }
        } catch (PDOException $e) {
            $queryResult = [];
            $queryFields = [];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>VIRZA - Админ панель</title>
<link rel="stylesheet" href="admin_panel_style.css" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;800&family=Ubuntu&family=Varela&display=swap" rel="stylesheet" />
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

<div class="admin-container">
    <div class="sidebar">
        <h2>Таблицы БД</h2>
        <ul>
            <li><a href="?table=applications" class="<?= $currentTable == 'applications' ? 'active' : '' ?>">Вакансии и Стажировки</a></li>
            <li><a href="?table=developers" class="<?= $currentTable == 'developers' ? 'active' : '' ?>">Разработчики</a></li>
            <li><a href="?table=games" class="<?= $currentTable == 'games' ? 'active' : '' ?>">Игры</a></li>
            <li><a href="?table=game_features" class="<?= $currentTable == 'game_features' ? 'active' : '' ?>">Характеристики игр</a></li>
            <li><a href="?table=news" class="<?= $currentTable == 'news' ? 'active' : '' ?>">Новости</a></li>
            <li><a href="?table=resumes" class="<?= $currentTable == 'resumes' ? 'active' : '' ?>">Резюме</a></li>
            <li><a href="?table=reviews" class="<?= $currentTable == 'reviews' ? 'active' : '' ?>">Отзывы</a></li>
            <li><a href="?table=users" class="<?= $currentTable == 'users' ? 'active' : '' ?>">Пользователи</a></li>
        </ul>

        <h2 class="query-title">Запросы</h2>
        <ul>
            <li><a href="?query=1" class="<?= $currentQuery == 1 ? 'active' : '' ?>">1. Игры по году выпуска</a></li>
            <li><a href="?query=2" class="<?= $currentQuery == 2 ? 'active' : '' ?>">2. Все разработчики</a></li>
            <li><a href="?query=3" class="<?= $currentQuery == 3 ? 'active' : '' ?>">3. Игры с рейтингом выше</a></li>
            <li><a href="?query=4" class="<?= $currentQuery == 4 ? 'active' : '' ?>">4. Игры по году</a></li>
            <li><a href="?query=5" class="<?= $currentQuery == 5 ? 'active' : '' ?>">5. Игры по цене</a></li>
            <li><a href="?query=6" class="<?= $currentQuery == 6 ? 'active' : '' ?>">6. Игры по жанру и платформе</a></li>
            <li><a href="?query=7" class="<?= $currentQuery == 7 ? 'active' : '' ?>">7. Количество игр по жанрам</a></li>
            <li><a href="?query=8" class="<?= $currentQuery == 8 ? 'active' : '' ?>">8. Игры по разработчику</a></li>
            <li><a href="?query=9" class="<?= $currentQuery == 9 ? 'active' : '' ?>">9. Игры по диапазону рейтинга</a></li>
            <li><a href="?query=10" class="<?= $currentQuery == 10 ? 'active' : '' ?>">10. Игры по остатку на складе</a></li>
        </ul>
    </div>

    <div class="main-content">
        <?php if ($currentTable): ?>
            <div class="table-container">
                <h2>Таблица: <?= htmlspecialchars(ucfirst($currentTable)) ?></h2>

                <?php if (!empty($tableData)): ?>
                    <table>
                        <thead>
                            <tr>
                                <?php foreach ($tableFields as $field): ?>
                                    <th><?= htmlspecialchars($field->name) ?></th>
                                <?php endforeach; ?>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tableData as $row): ?>
                                <tr>
                                    <?php foreach ($row as $value): ?>
                                        <td><?= htmlspecialchars($value) ?></td>
                                    <?php endforeach; ?>
                                    <td>
                                        <button class="btn btn-edit" onclick='openEditModal("<?= $currentTable ?>", <?= json_encode($row, JSON_HEX_APOS) ?>)'>Изменить</button>
                                        <button class="btn btn-danger" onclick='deleteRecord("<?= $currentTable ?>", "<?= htmlspecialchars($row['id'] ?? reset($row)) ?>")'>Удалить</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Нет данных в таблице.</p>
                <?php endif; ?>

                <div class="action-buttons">
                    <button class="btn btn-primary" onclick="openAddModal('<?= $currentTable ?>')">Добавить запись</button>
                </div>
            </div>
        <?php elseif ($currentQuery): ?>
            <div class="query-section">
                <h2>Результаты запроса</h2>

                <?php if (!empty($queryResult)): ?>
                    <div class="query-item">
                        <h3><?= htmlspecialchars($queryTitle) ?></h3>
                        <table>
                            <thead>
                                <tr>
                                    <?php foreach ($queryFields as $field): ?>
                                        <th><?= htmlspecialchars($field->name) ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($queryResult as $row): ?>
                                    <tr>
                                        <?php foreach ($row as $value): ?>
                                            <td><?= htmlspecialchars($value) ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if (in_array($queryNum, [3,4,5,6,8,9,10])): ?>
                        <div class="query-item">
                            <h3>Параметры запроса</h3>
                            <form method="get" action="admin_panel.php">
                                <input type="hidden" name="query" value="<?= $queryNum ?>">

                                <?php if ($queryNum == 3): ?>
                                    <div class="form-group">
                                        <label>Минимальный рейтинг:</label>
                                        <input type="number" name="rating" min="1" max="10" step="0.1" value="<?= htmlspecialchars($rating ?? 4) ?>">
                                    </div>
                                <?php elseif ($queryNum == 4): ?>
                                    <div class="form-group">
                                        <label>Год выпуска:</label>
                                        <input type="number" name="year" min="1980" max="<?= date('Y') ?>" value="<?= htmlspecialchars($year ?? date('Y')) ?>">
                                    </div>
                                <?php elseif ($queryNum == 5): ?>
                                    <div class="form-group">
                                        <label>Максимальная цена:</label>
                                        <input type="number" name="price" min="0" step="0.01" value="<?= htmlspecialchars($price ?? 30) ?>">
                                    </div>
                                <?php elseif ($queryNum == 6): ?>
                                    <div class="form-group">
                                        <label>Жанр:</label>
                                        <input type="text" name="genre" value="<?= htmlspecialchars($genre ?? 'RPG') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Платформа:</label>
                                        <input type="text" name="platform" value="<?= htmlspecialchars($platform ?? 'PC') ?>">
                                    </div>
                                <?php elseif ($queryNum == 8): ?>
                                    <div class="form-group">
                                        <label>ID разработчика:</label>
                                        <input type="number" name="developer" min="1" value="<?= htmlspecialchars($developer ?? 1) ?>">
                                    </div>
                                <?php elseif ($queryNum == 9): ?>
                                    <div class="form-group">
                                        <label>Минимальный рейтинг:</label>
                                        <input type="number" name="min_rating" min="1" max="10" step="0.1" value="<?= htmlspecialchars($minRating ?? 3) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Максимальный рейтинг:</label>
                                        <input type="number" name="max_rating" min="1" max="10" step="0.1" value="<?= htmlspecialchars($maxRating ?? 5) ?>">
                                    </div>
                                <?php elseif ($queryNum == 10): ?>
                                    <div class="form-group">
                                        <label>Максимальный остаток:</label>
                                        <input type="number" name="stock" min="0" value="<?= htmlspecialchars($stock ?? 10) ?>">
                                    </div>
                                <?php endif; ?>

                                <button type="submit" class="btn btn-primary">Применить</button>
                            </form>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <p>Нет данных по запросу.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="table-container">
                <h2>Добро пожаловать в админ-панель</h2>
                <p>Выберите таблицу или запрос из меню слева для работы с данными.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Модальные окна -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('addModal')">&times;</span>
        <h2>Добавить запись</h2>
        <form id="addForm" method="post" action="admin_actions.php">
            <input type="hidden" name="action" value="add" />
            <input type="hidden" name="table" id="addTableName" />
            <div id="addFormFields"></div>
            <button type="submit" class="btn btn-primary">Добавить</button>
        </form>
    </div>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('editModal')">&times;</span>
        <h2>Редактировать запись</h2>
        <form id="editForm" method="post" action="admin_actions.php">
            <input type="hidden" name="action" value="edit" />
            <input type="hidden" name="table" id="editTableName" />
            <input type="hidden" name="id" id="editRecordId" />
            <div id="editFormFields"></div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
</div>

<footer>
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
</footer>

<script src="admin_panel_script.js"></script>
</body>
</html>
