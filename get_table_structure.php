<?php
require_once 'db.php';

if (!isset($_GET['table'])) {
    echo json_encode([]);
    exit;
}

$table = $_GET['table'];

try {
    $stmt = $pdo->prepare("DESCRIBE `$table`");
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($columns);
} catch (PDOException $e) {
    echo json_encode([]);
}
