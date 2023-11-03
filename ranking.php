<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<html>
    <head>
        <title>¿Quién quiere ser millonario?</title>
        <noscript>
            This page needs JavaScript activated to work. 
            <style>div { background-color: white; display:none; }</style>
        </noscript>
        <meta author="" content="Claudia, Mehdi i Marcelo (2n DAW)">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="style.css" rel="stylesheet">
        <link rel="shortcut icon" href="imgs/logo.png" />
    </head>
    <body class="rankingPage">
        <header>
            <?php
                if ($_SESSION['language'] === 'spanish') {
                    echo "<a href='/index.php'><h1>¿Quién quiere ser millonario?</h1></a>";
                } elseif ($_SESSION['language'] === 'catalan') {
                    echo "<a href='/index.php'><h1>Qui vol ser milionari?</h1></a>";
                } elseif ($_SESSION['language'] === 'english') {
                    echo "<a href='/index.php'><h1>Who wants to be a millonarie?</h1></a>";
                }
            ?>
        </header>

    <div class="container">    
        <?php
            if ($_SESSION['language'] === 'spanish') {
                echo '<h3><em>Clasificaciones</em></h3><br>';
                echo '<table border="1" id="correctqueststable">';
                    echo '<tr>';
                        echo '<th>Nombre</th>';
                        echo '<th>Puntos</th>';
                        echo '<th>Tiempo</th>';
                        echo '<th>Puntos Totales</th>';
                    echo '</tr>';  
            
            } elseif ($_SESSION['language'] === 'catalan') {
                echo '<h3>Classificacions</h3><br>';
                echo '<table border="1" id="correctqueststable">';
                    echo '<tr>';
                        echo '<th>Nom</th>';
                        echo '<th>Punts</th>';
                        echo '<th>Temps</th>';
                        echo '<th>Punts Totals</th>';
                    echo '</tr>';
            
            } elseif ($_SESSION['language'] === 'english') {
                echo '<h3>Leaderboard</h3><br>';
                echo '<table border="1" id="correctqueststable">';
                echo '<tr>';
                    echo '<th>Name</th>';
                    echo '<th>Points</th>';
                    echo '<th>Time</th>';
                    echo '<th>Total Points</th>';
                echo '</tr>';
            }      

            $archivo = "records.txt";

            if (file_exists($archivo)) {
                $handle = fopen($archivo, "r");

                $data = array();

                while (($line = fgets($handle)) !== false) {
                    $parts = explode(",", $line);

                    if (count($parts) == 5) {
                        $nombre = $parts[0];
                        $puntos = (int)$parts[1];
                        $playerID = $parts[2];
                        $tiempo = $parts[3];
                        $puntosTotales = $parts[4];
                        $data[] = array('nombre' => $nombre, 'puntos' => $puntos, 'id' => $playerID, 'tiempo' => $tiempo, 'puntosTotales' => $puntosTotales);
                    }}

                fclose($handle);

                usort($data, function($a, $b) {
                    return $b['puntosTotales'] - $a['puntosTotales'];
                });

                foreach ($data as $row) {
                    if ($_SESSION['playerID'] == $row['id']) {
                        echo "<tr>";
                            echo "<td style='background-color: #a2ca83'>{$row['nombre']}</td>";
                            echo "<td style='background-color: #a2ca83'>{$row['puntos']}</td>";
                            echo "<td style='background-color: #a2ca83'>{$row['tiempo']}</td>";
                            echo "<td style='background-color: #a2ca83'>{$row['puntosTotales']}</td>";
                        echo "</tr>";
                    } else {
                        echo "<tr>";
                            echo "<td>{$row['nombre']}</td>";
                            echo "<td>{$row['puntos']}</td>";
                            echo "<td>{$row['tiempo']}</td>";
                            echo "<td>{$row['puntosTotales']}</td>";
                        echo "</tr>";
                    }
                }

                } else { echo "El archivo no existe."; }

            echo "</table>";
                
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
            <p><a href="gmail.com">Contact us</a></p>
            <p><a href="instagra.com">Follow us</a></p>
    </footer>
    
    </body>
</html>