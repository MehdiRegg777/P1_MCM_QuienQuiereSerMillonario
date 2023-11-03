<?php
session_start();
    isset($_POST['time']) ? $_SESSION['time'] = $_POST['time'] : null;
    isset($_POST['comodin50']) ? $_SESSION['comodin50'] = $_POST['comodin50'] : 'nousado';
    isset($_POST['comodinPublico']) ? $_SESSION['comodinPublico'] = $_POST['comodinPublico'] : 'nousado';
    isset($_POST['comodinTime']) ? $_SESSION['comodinTime'] = $_POST['comodinTime'] : 'nousado';
    isset($_POST['comodinLlamada']) ? $_SESSION['comodinLlamada'] = $_POST['comodinLlamada'] : 'nousado';
    isset($_POST['points']) ? $_SESSION['points'] = $_POST['points'] : null;
    $_SESSION['nivels'] = isset($_SESSION['nivels']) ? $_SESSION['nivels'] : 1;
?>

<!DOCTYPE html>
<html lang="es">
    <head>
            <title>¿Quién quiere ser millonario?</title>
            <noscript>
                This page needs JavaScript activated to work. 
                <style>div { background-color: white; display:none; }</style>
            </noscript>
            <meta author="" content="Claudia, Mehdi i Marcelo (2n DAW)">
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link href="style.css" rel="stylesheet">
            <link rel="shortcut icon" href="imgs/logo.png" />
    </head>

    <body class="gamePage">
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
        <div id="message" style="display: none;"></div>
        <div class="timer" id="timer">
            00:00
        </div>

        <div id="popupModal" class="popup">
            <div class="popup-public">
                <button class="close-button" onclick="cerrarImagen()">X</button>
                <img id="popupImage" src="" alt="Imagen">
                <div style="display: none;" id="preguntaLlamada">
                    <label style="display:block;" id="tituloLlamada">¿Cuántas veces sonó el audio?</label>
                    <input style="display:block;"  type="number" id="vecesAudio" name="vecesAudio" min="0" required>
                    <button style="display:block;"  id="enviarBtn" onclick="cantidadSonido()">Enviar</button>
                </div>
                <div style="display: none;" id="respuestaLlamada">
                    <h4>La respuesta correcta es:</h4>
                    <p  style="text-align: center;" id="RespuestaTexto"></p>
                </div>
            </div>
        </div>



        <div class="container1">
            <div class="comodinesBotones">
                <?php
                    if ($_SESSION['comodin50'] === 'nousado') {
                        echo '<button id="buttonComodin50" onclick="button50()"><i class="fa-solid fa-5"></i><i class="fa-solid fa-0">%</i></button>';
                    } elseif ($_SESSION['comodin50'] === 'usado') {
                        echo '<button id="buttonComodin50" onclick="button50()" disabled><i class="fa-solid fa-5"></i><i class="fa-solid fa-0">%</i></button>';
                    }
                    if ($_SESSION['nivels'] >= 2) {
                        if ($_SESSION['comodinTime'] === 'nousado') {
                            echo '<button id="buttonComodinTime" onclick="buttonTime()"><i class="fa-solid fa-stopwatch"></i></button>';
                        } elseif ($_SESSION['comodinTime'] === 'usado') {
                            echo '<button id="buttonComodinTime" onclick="buttonTime()" disabled><i class="fa-solid fa-stopwatch"></i></button>';
                        }
                    }else {
                        echo '<button id="buttonComodinTime" onclick="buttonTime()" disabled><i class="fa-solid fa-stopwatch"></i></button>';
                    }
                    if ($_SESSION['comodinPublico'] === 'nousado') {
                        echo '<button id="boton-publico" onclick="comodinPublico()"><i class="fa-solid fa-users"></i></button>';
                    } elseif ($_SESSION['comodinPublico'] === 'usado') {
                        echo '<button id="boton-publico" onclick="comodinPublico()" disabled><i class="fa-solid fa-users"></i></button>';
                    }
                    if ($_SESSION['comodinLlamada'] === 'nousado') {
                        echo '<button id="buttoncomodinLlamada" onclick="comodinLlamada()" ><i class="fa-solid fa-phone-volume"></i></button>';
                    } elseif ($_SESSION['comodinLlamada'] === 'usado') {
                        echo '<button id="buttoncomodinLlamada" onclick="comodinLlamada()" ><i class="fa-solid fa-phone-volume"></i></button>';
                    }
                ?>
            </div>
        </div>
        <?php
            $nivelmax = 6;

            for ($i = 1; $i <= 6; $i++) {
            $languages = array("catalan", "english", "spanish");
            foreach ($languages as $language) {
                $filename = "questions/".$language . "_" . $i . ".txt";
                $lines = file($filename);
                $modifiedContent = "";

                foreach ($lines as $line) {
                    $cleanLine = trim($line);
                    if (!empty($cleanLine)) {
                        $modifiedContent .= $cleanLine . "\n";
                    }
                }

                $modifiedContent = rtrim($modifiedContent);
                file_put_contents($filename, $modifiedContent);
            }}

            if (isset($_POST['niveles'])) {
                $_GET['nivel'] = intval($_POST['niveles']);
            } else { $_GET['nivel'] = 1; }

            $nivel_actual = $_GET['nivel'];

            if (!isset($_GET['preguntas']) || isset($_GET['nuevo_juego'])) {
                $contenido = file_get_contents("questions/{$_SESSION['language']}_$nivel_actual.txt");
                $lineas = explode("\n", $contenido);
                $preguntas = array();
                $imagen_actual = null; 

            for ($i = 0; $i < count($lineas); $i++) {
                $linea = trim($lineas[$i]);

            if (strpos($linea, '#') === 0) {
            
                $imagen_actual = trim(substr($linea, strlen('# ')));
            } else {
            
                if ($imagen_actual !== null) {

                    $pregunta = trim(substr($linea, 1));
                    $respuestas = array_map('trim', array_slice($lineas, $i + 1, 4));

                    foreach ($respuestas as $posicion => $respuesta) {
                        if (strpos($respuesta, '+') !== false) {
                            $respuestaCorrecta = $posicion;
                        }}

                        $preguntas[] = array(
                            "pregunta" => $pregunta,
                            "respuestas" => $respuestas,
                            "respuesta_correcta" => $respuestaCorrecta,
                            "imagen" => $imagen_actual,
                        );
                        $imagen_actual = null; 
                    }}}

            shuffle($preguntas);
            $_GET['preguntas'] = $preguntas;
            $_GET['pregunta_actual'] = 0;
        }

        $preguntas = $_GET['preguntas'];
        $nivels = $_GET['nivel'];
                    
                foreach ($preguntas as $key => $pregunta) {
                    if ($key >= 3) {
                        break;
                    }

                    $claseRespuesta = $key <= $_GET['pregunta_actual'] ? '' : 'bloqueada';
                    echo "<div class='pregunta $claseRespuesta' id='pregunta" . $key . "'>";
                    echo "<h2 class = 'questiontitle'>{$pregunta['pregunta']}</h2>";
                    
                    if ($nivels >= 2) {
                        echo "<div class='timerQuestion' id='timerQuestion' style='display: flex;'>30</div>";
                    }

                    $imagen = $pregunta['imagen']; // Ruta de la imagen
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $imagen)) {
                        echo '<img class="imag-question"  src="' . $imagen . '" alt="imagenes">';
                    }

                    echo "<div id='respuesta $claseRespuesta'>";
                    foreach ($pregunta['respuestas'] as $answerKey => $respuesta) {
                        $respuesta = str_replace(['+', '-', '*'], '', $respuesta);
                        $opciones = ['A', 'B', 'C', 'D'];
                        $opcionActual = $opciones[$answerKey];
                        echo "<div class='respuesta $claseRespuesta' data-pregunta='$key' data-respuesta='$answerKey' data-correcta='" . $pregunta['respuesta_correcta'] . "' id='respuesta-$key-$answerKey' onclick=\"seleccionarRespuesta('$key', '$answerKey')\">$opcionActual) $respuesta</div>";
                    }

                    if ($_SESSION['language'] === 'spanish') {
                        echo "<button class='responder-btn' data-pregunta='$key' id='responder-btn-$key' disabled onclick=\"responderPregunta('$key', '$nivel_actual', 'spanish')\">Responder</button>";
                    } elseif ($_SESSION['language'] === 'catalan') {
                        echo "<button class='responder-btn' data-pregunta='$key' id='responder-btn-$key' disabled onclick=\"responderPregunta('$key', '$nivel_actual', 'catalan')\">Respondre</button>";
                    } elseif ($_SESSION['language'] === 'english') {
                        echo "<button class='responder-btn' data-pregunta='$key' id='responder-btn-$key' disabled onclick=\"responderPregunta('$key', '$nivel_actual', 'english')\">Reply</button>";
                    }

                    echo "</div>";
                    echo "</div>";
                }

                echo "<p class='nivel_actual' nivelactual=$nivel_actual style='display: none;'></p>";
                $nivels++;
                $_SESSION['nivels'] = $nivel_actual + 1;
                echo "<div class='ghof-buttons'>";

                if ($_SESSION['language'] === 'spanish') {
                    echo "<button id='next-question' onclick='nextQuestion($nivels)' style='display: none;'>Siguiente pregunta</button>";
                } elseif ($_SESSION['language'] === 'catalan') {
                    echo "<button id='next-question' onclick='nextQuestion($nivels)' style='display: none;'>Següent pregunta</button>";
                } elseif ($_SESSION['language'] === 'english') {
                    echo "<button id='next-question' onclick='nextQuestion($nivels)' style='display: none;'>Next question</button>";
                }
                echo "</div>";
        ?>
        <!-- FIN DEL PHP. -->

        <audio id="correctSound" src="mp3/correct.mp3"></audio>
        <audio id="incorrectSound" src="mp3/fail.mp3"></audio>
        <script src="funcionGame.js"></script>
        <script src="funcionLanguage.js"></script>
        <footer class="footerinfo">
            <p>© MCM S.A.</p>
            <p><a href="gmail.com">Contact us</a></p>
            <p><a href="instagra.com">Follow us</a></p>
        </footer>
    </body>
</html>