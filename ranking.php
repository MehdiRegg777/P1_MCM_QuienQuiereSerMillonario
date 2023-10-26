<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<html>
    <head>
        <title>¿Quién quiere ser millonario?</title>
        <meta author="" content="Claudia, Mehdi i Marcelo (2n DAW)">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="style.css" rel="stylesheet">
        <link rel="shortcut icon" href="imgs/logo.png" />
    </head>
    <body>
        <header>
            <?php
            if ($_SESSION['language'] === 'spanish') {
                echo "<h1>¿Quién quiere ser millonario?</h1>";
            } elseif ($_SESSION['language'] === 'catalan') {
                echo "<h1>Qui vol ser milionari?</h1>";
            } elseif ($_SESSION['language'] === 'english') {
                echo "<h1>Who wants to be a millionaire?</h1>";
            }
            ?>
        </header>
    <div class="container">    
        <?php
        if ($_SESSION['language'] === 'spanish') {
            echo '<h3>Clasificaciones</h3><br>';
            echo '<table border="1" id="correctqueststable">';
            echo '<tr>';
            echo '<th>Nombre</th>';
            echo '<th>Puntos</th>';
            echo '<th>ID</th>';
            echo '</tr>';  
        } elseif ($_SESSION['language'] === 'catalan') {
            echo '<h3>Classificacions</h3><br>';
            echo '<table border="1" id="correctqueststable">';
            echo '<tr>';
            echo '<th>Nom</th>';
            echo '<th>Punts</th>';
            echo '<th>ID</th>';
            echo '</tr>';
        } elseif ($_SESSION['language'] === 'english') {
            echo '<h3>Leaderboard</h3><br>';
            echo '<table border="1" id="correctqueststable">';
            echo '<tr>';
                echo '<th>Name</th>';
                echo '<th>Points</th>';
                echo '<th>ID</th>';
            echo '</tr>';
        }      
        ?>

            <?php
                // Ruta del archivo de registros
                $archivo = "records.txt";

                // Verifica si el archivo existe
                if (file_exists($archivo)) {
                    // Abre el archivo para lectura
                    $handle = fopen($archivo, "r");

                    // Inicializa un array para almacenar los datos
                    $data = array();

                    // Recorre el archivo línea por línea
                    while (($line = fgets($handle)) !== false) {
                        // Divide la línea en sus partes separadas por comas
                        $parts = explode(",", $line);

                        // Verifica que haya tres partes
                        if (count($parts) == 3) {
                            // Asigna las partes a variables
                            $nombre = $parts[0];
                            $puntos = (int)$parts[1]; // Convierte los puntos a entero
                            $id = $parts[2];

                            // Almacena los datos en el array
                            $data[] = array('nombre' => $nombre, 'puntos' => $puntos, 'id' => $id);
                        }
                    }

                    // Cierra el archivo
                    fclose($handle);

                    // Ordena el array por la columna de puntos
                    usort($data, function($a, $b) {
                        return $b['puntos'] - $a['puntos'];
                    });

                    // Imprime la tabla ordenada
                    
                    foreach ($data as $row) {
                        echo "<tr>";
                        echo "<td>{$row['nombre']}</td>";
                        echo "<td>{$row['puntos']}</td>";
                        echo "<td>{$row['id']}</td>";
                        echo "</tr>";
                    }

                } else {
                    echo "El archivo no existe.";
                }
                ?>


        </table>
        <?php
        if ($_SESSION['language'] === 'spanish') {
            echo '<a class="play-button" href="index.php">Volver al inicio</a>';
        } elseif ($_SESSION['language'] === 'catalan') {
            echo "<a class='play-button' href='index.php'><em>Tornar a l'inici</em></a>";
        } elseif ($_SESSION['language'] === 'english') {
            echo '<a class="play-button" href="index.php"><em>Back to the start</em></a>';
        }
        ?>
    </div>
    <footer class="footerinfo">
            <p>© MCM S.A.</p>
            <p>Contact us</p>
            <p>Follow us</p>
            <p>empresa@domini.cat</p>
            <p>twt ig p</p>
        </footer>
    </body>
</html>
