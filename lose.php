<?php
session_start();
?>

<!DOCTYPE html>
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
            <h1>¿Quién quiere ser millonario?</h1>
        </header>
        <audio id="gameOver" src="gameover.mp3" preload="auto" style="display:none"></audio>

        <div class="container">
            
            <div class="arribapregunta">
                <h2>¡Has Perdido!</h2>
                <h3>Clasificaciones</h3>

                <?php
                      if ($_SERVER["REQUEST_METHOD"] == "GET") {
                        $puntos = $_GET["puntage"];
                        echo '<table border="1">';
                        echo '<tr>';
                        echo '<th>Preguntas Acertadas</th>';
                        echo '<th>' . $puntos . '</th>';
                        echo '</tr>';
                        echo '</table>';
                      }
                ?>


                <h5>Si quieres guardar tu partida dale al boton PUBLISH</h5>
                <a class="play-button" onclick='publishGame()'>PUBLISH</a>
                <a class="halloffame-button" href="ranking.php"><em>Hall of fame</em></a>
                <a class="play-button" href="index.php">Volver al inicio</a>
            </div>

            <div class="formularioPunage">

            <?php
            // Obtener la ID de sesión
            $sessionID = session_id();
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                $puntos = $_GET["puntage"];
                echo '<form id="guardarpartida" method="post" style="display: none;">
                    <label for="nombre">Nombre del Jugador:</label>
                    <input type="text" name="datos[nombre]" id="nombre" required><br>
                    <input type="hidden" name="datos[puntuacion]" id="puntuacion"  value="' . $puntos . '"><br>
                    <input type="hidden" name="datos[id]" id="id" value="' . $sessionID . '"><br>        
                    <input type="submit" value="Guardar Puntuación">
                </form>';
            } 
        
            
        

            ?>

            <?php
            if (isset($_POST["datos"])){
                $file = fopen("records.txt", "a");

                $nombre = $_POST["datos"]["nombre"];
                $puntuacion = $_POST["datos"]["puntuacion"];
                $id = $_POST["datos"]["id"];

                $comanda = $nombre . "," . $puntuacion . "," . $id;

                fwrite($file, $comanda . "\n");
                fclose($file);
            }
            ?>


        </div>
        </div>

        
        
        <footer class="footerinfo">
            <p>© MCM S.A.</p>
            <p>Contact us</p>
            <p>Follow us</p>
            <p>empresa@domini.cat</p>
            <p>twt ig p</p>
        </footer>
        <audio id="gameOver" autoplay>
            <source src="mp3/gameover.mp3" type="audio/mpeg">
        </audio>
        <script src="funcionPublish.js"></script>
    </body>
</html>