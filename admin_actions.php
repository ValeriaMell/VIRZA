<?php
require_once 'db.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$table = $_POST['table'] ?? '';
$id = $_POST['id'] ?? null;

if (!$table || !$action) {
    echo json_encode(['success' => false, 'message' => 'Не указаны таблица или действие']);
    exit;
}

try {
    // Получаем структуру таблицы
    $stmt = $pdo->prepare("DESCRIBE `$table`");
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $fields = [];
    $values = [];
    $placeholders = [];

    foreach ($columns as $column) {
        $name = $column['Field'];
        if ($name === 'id') continue;

        if (isset($_POST[$name])) {
            $fields[] = "`$name`";
            $values[] = $_POST[$name];
            $placeholders[] = '?';
        }
    }

    // Валидация для таблицы reviews
    if ($table === 'reviews') {
        foreach ($columns as $column) {
            if ($column['Field'] === 'rating') {
                $rating = $_POST['rating'] ?? null;
                if (!is_numeric($rating) || intval($rating) != $rating || $rating < 1 || $rating > 10) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Рейтинг должен быть целым числом от 1 до 10'
                    ]);
                    exit;
                }
            }
        }
    }

    // Удаление
    if ($action === 'delete' && $id) {
        $stmt = $pdo->prepare("DELETE FROM `$table` WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
        exit;
    }

    // Добавление
    if ($action === 'add') {
        $query = "INSERT INTO `$table` (" . implode(',', $fields) . ") VALUES (" . implode(',', $placeholders) . ")";
        $stmt = $pdo->prepare($query);
        $stmt->execute($values);
        echo json_encode(['success' => true, 'message' => 'Запись добавлена']);
        exit;
    }

    // Обновление
    if ($action === 'edit' && $id) {
        $setParts = [];
        foreach ($fields as $field) {
            $setParts[] = "$field = ?";
        }
        $query = "UPDATE `$table` SET " . implode(', ', $setParts) . " WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $values[] = $id;
        $stmt->execute($values);
        echo json_encode(['success' => true, 'message' => 'Запись обновлена']);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Неверное действие']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка БД: ' . $e->getMessage()]);
}
