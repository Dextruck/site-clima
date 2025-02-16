<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $url = $_POST['url'];
    $attributes = $_POST['attributes'];

    // Inserindo novo link na tabela `weather_links`
    $stmt = $conn->prepare("INSERT INTO weather_links (name, url) VALUES (?, ?) RETURNING id");
    $stmt->execute([$name, $url]);
    $linkId = $stmt->fetchColumn();

    // Inserindo relacionamentos na tabela `weather_links_atributes`
    foreach ($attributes as $attributeId) {
        $stmt = $conn->prepare("INSERT INTO weather_links_atributes (id_wheater_links, id_atributes) VALUES (?, ?)");
        $stmt->execute([$linkId, $attributeId]);
    }
    header('Location: index.php');
    exit;
}

// Buscar todos os atributos disponíveis
$attributeStmt = $conn->query("SELECT id, name FROM atributes");
$attributes = $attributeStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Link de Previsão do Tempo</title>
</head>
<body>
    <h1>Adicionar Link</h1>
    <form action="create.php" method="post">
        <label>Nome do Link:</label><br>
        <input type="text" name="name" required><br>

        <label>URL:</label><br>
        <input type="url" name="url" required><br>

        <label>Atributos:</label><br>
        <?php foreach ($attributes as $attribute): ?>
            <input type="checkbox" name="attributes[]" value="<?= $attribute['id']; ?>">
            <?= htmlspecialchars($attribute['name']); ?><br>
        <?php endforeach; ?>

        <button type="submit">Salvar</button>
    </form>
</body>
</html>
