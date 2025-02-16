<?php
require 'db.php';

$id = $_GET['id'];

// Excluir relacionamentos de atributos
$conn->prepare("DELETE FROM weather_links_atributes WHERE id_wheater_links = ?")->execute([$id]);

// Excluir link
$conn->prepare("DELETE FROM weather_links WHERE id = ?")->execute([$id]);

header('Location: index.php');
exit;
?>
