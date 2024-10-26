<?php
header("Content-Type: application/json");

$host = 'db';
$db = 'weather_db';
$user = 'myuser';
$pass = 'mypassword';

try {
    $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$db;", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM weather_links");
    $links = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($links);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
