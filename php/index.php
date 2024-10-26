<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previsão do Tempo</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Links de Previsão do Tempo</h1>
    </header>
    <main>
        <section id="search">
            <h2>Filtrar Sites</h2>
            <input type="text" id="searchInput" placeholder="Digite características...">
        </section>
        <section id="links">
            <h2>Sites de Previsão do Tempo</h2>
            <ul id="linkList">
                <?php
                // Conectar ao banco de dados
                $conn = new PDO("pgsql:host=db;port=5432;dbname=weather_db", "myuser", "mypassword");

                // Buscar dados da tabela
                $stmt = $conn->query("SELECT * FROM weather_links");
                $links = $stmt->fetchAll();

                // Exibir cada link com seus atributos
                foreach ($links as $link) {
                    echo "<li data-attributes=\"" . htmlspecialchars($link['attributes']) . "\">";
                    echo "<a href=\"" . htmlspecialchars($link['url']) . "\" target=\"_blank\">" . htmlspecialchars($link['name']) . "</a>";
                    echo "</li>";
                }
                ?>
            </ul>
        </section>
    </main>
    <script src="script/script.js"></script>
</body>
</html>
