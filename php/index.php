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
        <?php
        // Conectar ao banco de dados
        $conn = new PDO("pgsql:host=db;port=5432;dbname=weather_db", "myuser", "mypassword");

        // Buscar dados da tabela com JOIN para trazer atributos relacionados
        $stmt = $conn->query("
            SELECT wl.id, wl.name, wl.url, string_agg(a.name, ', ') as attributes, wl.collection
            FROM weather_links wl
            LEFT JOIN weather_links_atributes wla 
            ON wl.id = wla.id_wheater_links
            LEFT JOIN atributes a 
            ON wla.id_atributes = a.id
            GROUP BY wl.id
            ORDER BY wl.collection DESC, wl.name
        ");

        $links = $stmt->fetchAll();
        $collection = null;

        foreach ($links as $link) {
            if (is_null($collection) || $collection != $link['collection']) {
                if (!is_null($collection)) {
                    echo "</ul>";
                }
            
                echo "<div class='spacer'></div>";
                echo "<h2>" . htmlspecialchars($link['collection']) . "</h2>";
                echo "<ul class=\"linkList\">";
            }
            $collection = $link['collection'];
            
            // Verifica se há atributos antes de adicionar
            if (isset($link['attributes'])){
                $attributesForSearch = $link['attributes'];
                // Se a coleção e o nome não estiverem vazios, adiciona-os aos atributos
                if (!empty($link['collection']) && !empty($link['name'])) {
                    $attributesForSearch .= ','.$link['collection'].','.$link['name'];
                }
            }else{
                if (!empty($link['collection']) && !empty($link['name'])) {
                    $attributesForSearch = $link['collection'].','.$link['name'];
                }
            }


            echo "<li data-attributes=\"" . htmlspecialchars($attributesForSearch) . "\">";
            echo "<a href=\"" . htmlspecialchars($link['url']) . "\" target=\"_blank\">" . htmlspecialchars($link['name']) . "</a>";
            echo "</li>";
        }
        echo "</ul>";
        ?>
    </section>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Previsão do Tempo</p>
    </footer>
    <script src="script/script.js"></script>
</body>

</html>
