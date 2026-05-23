<?php
require_once __DIR__ . '/config.php';

function db(): mysqli {
    static $conn = null;
    if ($conn !== null) return $conn;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->set_charset(DB_CHARSET);
    return $conn;
}

function db_one(string $sql, string $types = '', array $params = []): ?array {
    $stmt = db()->prepare($sql);
    if ($types !== '') $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res ? $res->fetch_assoc() : null;
    $stmt->close();
    return $row ?: null;
}

function db_all(string $sql, string $types = '', array $params = []): array {
    $stmt = db()->prepare($sql);
    if ($types !== '') $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $res = $stmt->get_result();
    $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    $stmt->close();
    return $rows;
}

function db_exec(string $sql, string $types = '', array $params = []): int {
    $stmt = db()->prepare($sql);
    if ($types !== '') $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $affected = $stmt->affected_rows;
    $insert_id = db()->insert_id;
    $stmt->close();
    return $insert_id > 0 ? $insert_id : $affected;
}
