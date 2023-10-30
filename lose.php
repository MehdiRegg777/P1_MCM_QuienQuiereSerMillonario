<?php
session_start();
isset($_POST['points']) ? $_SESSION['points'] = $_POST['points'] : null;
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
    <body class="losePage">
        
            <?php
               if (!isset($_GET["userpoints"])){
                        header('HTTP/1.0 403 Forbidden');
                        echo 'No pots accedir a aquesta pàgina.';
                        exit;
               } else {
            
                echo "<header>";

                if ($_SESSION['language'] === 'spanish') {
                    echo "<a href='/index.php'><h1>¿Quién quiere ser millonario?</h1></a>";
                
                } elseif ($_SESSION['language'] === 'catalan') {
                    echo "<a href='/index.php'><h1>Qui vol ser milionari?</h1></a>";
                
                } elseif ($_SESSION['language'] === 'english') {
                    echo "<a href='/index.php'><h1>Who wants to be a millonarie</h1></a>";
                }
            
                echo "</header>
        
                <audio id='gameOver' src='gameover.mp3' preload='auto' style='display: none'></audio>

                <div class='container'>
                    <div class='arribapregunta'>";
                    
                        if ($_SESSION['language'] === 'spanish') {
                            echo "<h2>¡Has perdido!</h2>";
                            echo "<h3><em>Clasificaciones</em></h3>";
                        
                        } elseif ($_SESSION['language'] === 'catalan') {
                            echo "<h2>Has perdut!</h2>";
                            echo "<h3><em>Classificacions</em></h3>";
                        
                        } elseif ($_SESSION['language'] === 'english') {
                            echo "<h2>You lost!</h2>";
                            echo "<h3><em>Leaderboard</em></h3>";                    
                        }
                    
                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                        $puntos = $_GET["userpoints"];
                        echo '<table border="1" id="correctqueststable">';
                        echo '<tr>';
                        if ($_SESSION['language'] === 'spanish') {
                            echo '<th>Preguntas acertadas</th>';
                            echo '<td>' . $puntos . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Tiempo tardado</th>';
                            echo '<td>' . $_SESSION['time'] . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Puntos totales</th>';
                            echo '<td>' . $_SESSION['points'] . '</td>';
                        } elseif ($_SESSION['language'] === 'catalan') {
                            echo '<th>Preguntas encertades</th>';
                            echo '<td>' . $puntos . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Temps trigat</th>';
                            echo '<td>' . $_SESSION['time'] . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Punts totals</th>';
                            echo '<td>' . $_SESSION['points'] . '</td>';
                        } elseif ($_SESSION['language'] === 'english') {
                            echo '<th>Correct Answers</th>';
                            echo '<td>' . $puntos . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Time taken</th>';
                            echo '<td>' . $_SESSION['time'] . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Total points</th>';
                            echo '<td>' . $_SESSION['points'] . '</td>';
                        }
                        echo '</tr>';
                        echo '</table>';
                    }

                if ($_SESSION['language'] === 'spanish') {
                    echo '<p>Si quieres guardar tu partida da clic en el botón "<em>Publicar</em>".</p>';
                    echo '<a class="play-button" onclick="publishGame()"><em>Publicar</em></a>';
                    echo '<a class="halloffame-button" href="ranking.php"><em>Hall of fame</em></a>';
                    echo '<a class="play-button" href="index.php"><em>Volver al inicio</em></a>';
                
                } elseif ($_SESSION['language'] === 'catalan') {
                    echo '<p>Si vols desar la teva partida, fes clic al botó "<em>Publicar</em>".</p>';
                    echo '<a class="play-button" onclick="publishGame()"><em>Publicar</em></a>';
                    echo '<a class="halloffame-button" href="ranking.php"><em>Hall of fame</em></a>';
                    echo "<a class='play-button' href='index.php'><em>Tornar a l'inici</em></a>";
                
                } elseif ($_SESSION['language'] === 'english') {
                    echo '<p>If you want to save your game, click on the "<em>Publish</em>" button.</p>';
                    echo '<a class="play-button" onclick="publishGame()"><em>Publish</em></a>';
                    echo '<a class="halloffame-button" href="ranking.php"><em>Hall of fame</em></a>';
                    echo '<a class="play-button" href="index.php"><em>Back to the start</em></a>';             
                }
                echo "</div>

                <div class='formularioPunage'>";
                        $sessionID = session_id();
                        if ($_SERVER["REQUEST_METHOD"] == "GET") {
                            $puntos = $_GET["userpoints"];
                            if ($_SESSION['language'] === 'spanish') {
                                echo '<form id="guardarpartida" method="post" style="display: none;">
                                <label for="nombre">Nombre del jugador:</label>
                                <input type="text" name="datos[nombre]" id="nombre" required><br>
                                <input type="hidden" name="datos[puntuacion]" id="puntuacion"  value="' . $puntos . '"><br>
                                <input type="hidden" name="datos[id]" id="id" value="' . $sessionID . '"><br>
                                <input type="submit" value="Guardar puntuación" id ="savepunt-button">
                                </form>';
                            } elseif ($_SESSION['language'] === 'catalan') {
                                echo '<form id="guardarpartida" method="post" style="display: none;">
                                <label for="nombre">Nom del jugador:</label>
                                <input type="text" name="datos[nombre]" id="nombre" required><br>
                                <input type="hidden" name="datos[puntuacion]" id="puntuacion"  value="' . $puntos . '"><br>
                                <input type="hidden" name="datos[id]" id="id" value="' . $sessionID . '"><br>
                                <input type="submit" value="Desa la puntuació" id ="savepunt-button">
                                </form>';
                            } elseif ($_SESSION['language'] === 'english') {
                                echo '<form id="guardarpartida" method="post" style="display: none;">
                                <label for="nombre">Player Name:</label>
                                <input type="text" name="datos[nombre]" id="nombre" required><br>
                                <input type="hidden" name="datos[puntuacion]" id="puntuacion"  value="' . $puntos . '"><br>
                                <input type="hidden" name="datos[id]" id="id" value="' . $sessionID . '"><br>
                                <input type="submit" value="Save Score" id ="savepunt-button">
                                </form>';                   
                            }
                        }

                        if (isset($_POST["datos"])){
                            $file = fopen("records.txt", "a");
                            $nombre = $_POST["datos"]["nombre"];
                            $puntuacion = $_POST["datos"]["puntuacion"];
                            $id = $_POST["datos"]["id"];
                            $comanda = $nombre . "," . $puntuacion . "," . $id;
                            fwrite($file, $comanda . "\n");
                            fclose($file);
                        }

                    echo "</div>
                </div>
                
                <footer class='footerinfo'>
                    <p>© MCM S.A.</p>
                    <p><a href='gmail.com'>Contact us</a></p>
                    <p><a href='instagram.com'>Follow us</a></p>
                </footer>
                <audio id='gameOver' autoplay>
                    <source src='mp3/gameover.mp3' type='audio/mpeg'>
                </audio>
                <script src='funcionGame.js'></script>";
            }
        ?>
    </body>
</html>