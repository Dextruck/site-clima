<?php
require 'db.php';

$id = $_GET['id'];

// Atualizar link e atributos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $url = $_POST['url'];
    $attributes = $_POST['attributes'];

    // Atualizar link
    $stmt = $conn->prepare("UPDATE weather_links SET name = ?, url = ? WHERE id = ?");
    $stmt->execute([$name, $url, $id]);

    // Atualizar atributos relacionados
    $conn->prepare("DELETE FROM weather_links_atributes WHERE id_wheater_links = ?")->execute([$id]);
    foreach ($attributes as $attributeId) {
        $conn->prepare("INSERT INTO weather_links_atributes (id_wheater_links, id_atributes) VALUES (?, ?)")->execute([$id, $attributeId]);
    }
    header('Location: index.php');
    exit;
}

// Buscar dados do link
$stmt = $conn->prepare("SELECT * FROM weather_links WHERE id = ?");
$stmt->execute([$id]);
$link = $stmt->fetch();

// Buscar todos os atributos
$attributeStmt = $conn->query("SELECT id, name FROM atributes");
$attributes = $attributeStmt->fetchAll();

// Buscar atributos já selecionados
$linkAttributesStmt = $conn->prepare("SELECT id_atributes FROM weather_links_atributes WHERE id_wheater_links = ?");
$linkAttributesStmt->execute([$id]);
$linkAttributes = $linkAttributesStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Link</title>
</head>
<body>
    <h1>Editar Link</h1>
    <form action="update.php?id=<?= $id; ?>" method="post">
        <label>Nome do Link:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($link['name']); ?>" required><br>

        <label>URL:</label><br>
        <input type="url" name="url" value="<?= htmlspecialchars($link['url']); ?>" required><br>

        <label>Atributos:</label><br>
        <?php foreach ($attributes as $attribute): ?>
            <input type="checkbox" name="attributes[]" value="<?= $attribute['id']; ?>" <?= in_array($attribute['id'], $linkAttributes) ? 'checked' : ''; ?>>
            <?= htmlspecialchars($attribute['name']); ?><br>
        <?php endforeach; ?>

        <button type="submit">Salvar</button>
    </form>
</body>
</html>
