<?php
// db.php
try {
    $conn = new PDO("pgsql:host=db;port=5432;dbname=weather_db", "myuser", "mypassword");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit();
}
?>
