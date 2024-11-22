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
            <!-- <h2>Sites de Previsão do Tempo</h2> -->

            <?php
            // Conectar ao banco de dados
            $conn = new PDO("pgsql:host=db;port=5432;dbname=weather_db", "myuser", "mypassword");

            // Buscar dados da tabela com JOIN para trazer atributos relacionados
            $stmt = $conn->query("
                SELECT wl.id, wl.name, wl.url, string_agg(a.name, ', ') as attributes, wl.collection
                FROM weather_links wl
                left JOIN weather_links_atributes wla 
                ON wl.id = wla.id_wheater_links
                left JOIN atributes a 
                ON wla.id_atributes = a.id
                GROUP BY wl.id
                order by wl.collection desc, wl.name
                ");

            $links = $stmt->fetchAll();
            $collection = null;
            // Exibir cada link com seus atributos

            foreach ($links as $link) {
                if (is_null($collection) || $collection != $link['collection']) {
                    echo "<h2>" . $link['collection'] . "</h2>";
                    echo "<ul id=\"linkList\">";
                }
                $collection = $link['collection'];
                // Usar atributos diretamente, pois já é uma string
                echo "<li data-attributes=\"" . htmlspecialchars($link['attributes'] . $link['collection'] . $link['name']) . "\">";
                echo "<a href=\"" . htmlspecialchars($link['url']) . "\" target=\"_blank\">" . htmlspecialchars($link['name']) . "</a>";
                echo "</li>";
            }
            echo "</ul>";
            ?>

        </section>
    </main>
    <script src="script/script.js"></script>
</body>

</html>