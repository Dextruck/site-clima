<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previsão do Tempo</title>
    <link rel="stylesheet" href="../css/styles.css">
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
        <?php
            try {
                // Conectar ao banco de dados
                $conn = new PDO("pgsql:host=db;port=5432;dbname=weather_db", "myuser", "mypassword");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Buscar dados da tabela com JOIN para trazer atributos relacionados
                $stmt = $conn->query("
                    SELECT wl.id, wl.name, wl.url, 
                    CASE
                        WHEN string_agg(a.name, ', ') IS NOT NULL 
                        THEN string_agg(a.name, ', ') || ',' || wl.collection || ',' || wl.name
                        ELSE wl.collection || ',' || wl.name
                    END AS attributes, 
                    wl.collection
                    FROM weather_links wl
                    LEFT JOIN weather_links_atributes wla ON wl.id = wla.id_wheater_links
                    LEFT JOIN atributes a ON wla.id_atributes = a.id
                    GROUP BY wl.id
                    ORDER BY wl.collection DESC, wl.name
                ");

                $links = $stmt->fetchAll();
                $collection = null;

                foreach ($links as $link) {
                    if (empty($link['name']) || empty($link['url']) || empty($link['collection'])) {
                        continue; // Pula links inválidos
                    }

                    if (is_null($collection) || $collection != $link['collection']) {
                        if (!is_null($collection)) {
                            echo "</ul>";
                        }
                        echo "<div class='spacer'></div>";
                        echo "<h2>" . htmlspecialchars($link['collection']) . "</h2>";
                        echo "<ul class=\"linkList\">";
                        $collection = $link['collection'];
                    }

                    $attributesForSearch = $link['attributes'] ?? '';
                    echo "<li data-attributes=\"" . htmlspecialchars($attributesForSearch) . "\">";
                    echo "<a href=\"" . htmlspecialchars($link['url']) . "\" target=\"_blank\">" . htmlspecialchars($link['name']) . "</a>";
                    echo "</li>";
                }
                echo "</ul>";
            } catch (PDOException $e) {
                echo "<p>Erro ao carregar os links: " . $e->getMessage() . "</p>";
            }
        ?>
    </section>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Previsão do Tempo</p>
    </footer>
    <script src="../script/script.js"></script>
</body>

</html>
