<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
            <title>¿Quién quiere ser millonario?</title>
            <meta author="" content="Claudia, Mehdi i Marcelo (2n DAW)">
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="style.css" rel="stylesheet">
            <link rel="shortcut icon" href="imgs/logo.png" />
    </head>

    <body>
        <div id="spanish">
        <header>
            <h1>¿Quién quiere ser millonario?</h1>
        </header>
        
        <?php
        
        if (isset($_GET['niveles'])) {
            $_GET['nivel'] = intval($_GET['niveles']);
        } else {
            $_GET['nivel'] = 1;
        }

        $nivel_actual = $_GET['nivel'];

        /* if ($nivel_actual === 1) {
            if (isset($_POST['language'])) {
                $language = $_POST['language']; // Obtener el idioma seleccionado
            }
            $_SESSION['language'] = $language;
        }
        $_GET['selectedLanguage'] = $_SESSION['language'];
        echo "<h2>{$_GET['selectedLanguage']}</h2>";
        echo "<h2>{$nivel_actual}</h2>";
        echo "<h2>{$_SESSION['language']}</h2>"; */
        if (!isset($_GET['preguntas']) || isset($_GET['nuevo_juego'])) {
            $contenido = file_get_contents("questions/spanish_$nivel_actual.txt");
            $lineas = explode("\n", $contenido);
            $preguntas = array();

            for ($i = 0; $i < count($lineas); $i += 5) {
                $pregunta = trim(substr($lineas[$i], 1));
                $respuestas = array_map('trim', array_slice($lineas, $i + 1, 4));

                foreach ($respuestas as $posicion => $respuesta) {
                    if (strpos($respuesta, '+') !== false) {
                        $respuestaCorrecta = $posicion;
                    }
                }

                $preguntas[] = array(
                    "pregunta" => $pregunta,
                    "respuestas" => $respuestas,
                    "respuesta_correcta" => $respuestaCorrecta,
                );
            }

            shuffle($preguntas);
            $_GET['preguntas'] = $preguntas;
            $_GET['pregunta_actual'] = 0;
        }

        $preguntas = $_GET['preguntas'];
        
        foreach ($preguntas as $key => $pregunta) {
            if ($key >= 3) {
                break;
            }

            $claseRespuesta = $key <= $_GET['pregunta_actual'] ? '' : 'bloqueada';
            echo "<div class='pregunta $claseRespuesta' id='pregunta" . $key . "'>";
            
            // AQUÍ LA PREGUNTA.
            echo "<h2 class = 'questiontitle'>{$pregunta['pregunta']}</h2>";
            echo "<div id='respuesta $claseRespuesta'>";
            
            foreach ($pregunta['respuestas'] as $answerKey => $respuesta) {
                $respuesta = str_replace(['+', '-', '*'], '', $respuesta);
                echo "<div class='respuesta $claseRespuesta' data-pregunta='$key' data-respuesta='$answerKey' data-correcta='" . $pregunta['respuesta_correcta'] . "' id='respuesta-$key-$answerKey' onclick=\"seleccionarRespuesta('$key', '$answerKey')\">$respuesta</div>";
            }
            
            echo "<button class='responder-btn' data-pregunta='$key' id='responder-btn-$key' disabled onclick=\"responderPregunta('$key', '$nivel_actual')\">Responder</button>";
            echo "</div>";
            echo "</div>";
        }
        
        $nivels = $_GET['nivel'];
        $nivels++;
        echo "<div class='ghof-buttons'>";
        echo "<button id='inicio-btn' onclick='regresarAlInicio()' style='display: none;' ><em><strong>Volver al inicio</em></strong></button>";
        echo "<button id='next-question' onclick='nextQuestion($nivels)' style='display: none;' >Siguiente pregunta</button>";
        echo "</div>"
        ?>
        </div>
        <div id="catalan" style="display: none;">
        <header>
            <h1>Qui vol ser milionari?</h1>
        </header>
        
        <?php
        
        if (isset($_GET['niveles'])) {
            $_GET['nivel'] = intval($_GET['niveles']);
        } else {
            $_GET['nivel'] = 1;
        }

        $nivel_actual = $_GET['nivel'];

        /* if ($nivel_actual === 1) {
            if (isset($_POST['language'])) {
                $language = $_POST['language']; // Obtener el idioma seleccionado
            }
            $_SESSION['language'] = $language;
        }
        $_GET['selectedLanguage'] = $_SESSION['language'];
        echo "<h2>{$_GET['selectedLanguage']}</h2>";
        echo "<h2>{$nivel_actual}</h2>";
        echo "<h2>{$_SESSION['language']}</h2>"; */
        if (!isset($_GET['preguntas']) || isset($_GET['nuevo_juego'])) {
            $contenido = file_get_contents("questions/catalan_$nivel_actual.txt");
            $lineas = explode("\n", $contenido);
            $preguntas = array();

            for ($i = 0; $i < count($lineas); $i += 5) {
                $pregunta = trim(substr($lineas[$i], 1));
                $respuestas = array_map('trim', array_slice($lineas, $i + 1, 4));

                foreach ($respuestas as $posicion => $respuesta) {
                    if (strpos($respuesta, '+') !== false) {
                        $respuestaCorrecta = $posicion;
                    }
                }

                $preguntas[] = array(
                    "pregunta" => $pregunta,
                    "respuestas" => $respuestas,
                    "respuesta_correcta" => $respuestaCorrecta,
                );
            }

            shuffle($preguntas);
            $_GET['preguntas'] = $preguntas;
            $_GET['pregunta_actual'] = 0;
        }

        $preguntas = $_GET['preguntas'];
        
        foreach ($preguntas as $key => $pregunta) {
            if ($key >= 3) {
                break;
            }

            $claseRespuesta = $key <= $_GET['pregunta_actual'] ? '' : 'bloqueada';
            echo "<div class='pregunta $claseRespuesta' id='pregunta" . $key . "'>";
            
            // AQUÍ LA PREGUNTA.
            echo "<h2 class = 'questiontitle'>{$pregunta['pregunta']}</h2>";
            echo "<div id='respuesta $claseRespuesta'>";
            
            foreach ($pregunta['respuestas'] as $answerKey => $respuesta) {
                $respuesta = str_replace(['+', '-', '*'], '', $respuesta);
                echo "<div class='respuesta $claseRespuesta' data-pregunta='$key' data-respuesta='$answerKey' data-correcta='" . $pregunta['respuesta_correcta'] . "' id='respuesta-$key-$answerKey' onclick=\"seleccionarRespuesta('$key', '$answerKey')\">$respuesta</div>";
            }
            
            echo "<button class='responder-btn' data-pregunta='$key' id='responder-btn-$key' disabled onclick=\"responderPregunta('$key', '$nivel_actual')\">Responder</button>";
            echo "</div>";
            echo "</div>";
        }
        
        $nivels = $_GET['nivel'];
        $nivels++;
        echo "<div class='ghof-buttons'>";
        echo "<button id='inicio-btn' onclick='regresarAlInicio()' style='display: none;' ><em><strong>Volver al inicio</em></strong></button>";
        echo "<button id='next-question' onclick='nextQuestion($nivels)' style='display: none;' >Siguiente pregunta</button>";
        echo "</div>"
        ?>
        </div>
        <div id="english" style="display: none;">
        <header>
            <h1>Who wants to be a millionaire?</h1>
        </header>
        
        <?php
        
        if (isset($_GET['niveles'])) {
            $_GET['nivel'] = intval($_GET['niveles']);
        } else {
            $_GET['nivel'] = 1;
        }

        $nivel_actual = $_GET['nivel'];

        /* if ($nivel_actual === 1) {
            if (isset($_POST['language'])) {
                $language = $_POST['language']; // Obtener el idioma seleccionado
            }
            $_SESSION['language'] = $language;
        }
        $_GET['selectedLanguage'] = $_SESSION['language'];
        echo "<h2>{$_GET['selectedLanguage']}</h2>";
        echo "<h2>{$nivel_actual}</h2>";
        echo "<h2>{$_SESSION['language']}</h2>"; */
        if (!isset($_GET['preguntas']) || isset($_GET['nuevo_juego'])) {
            $contenido = file_get_contents("questions/spanish_$nivel_actual.txt");
            $lineas = explode("\n", $contenido);
            $preguntas = array();

            for ($i = 0; $i < count($lineas); $i += 5) {
                $pregunta = trim(substr($lineas[$i], 1));
                $respuestas = array_map('trim', array_slice($lineas, $i + 1, 4));

                foreach ($respuestas as $posicion => $respuesta) {
                    if (strpos($respuesta, '+') !== false) {
                        $respuestaCorrecta = $posicion;
                    }
                }

                $preguntas[] = array(
                    "pregunta" => $pregunta,
                    "respuestas" => $respuestas,
                    "respuesta_correcta" => $respuestaCorrecta,
                );
            }

            shuffle($preguntas);
            $_GET['preguntas'] = $preguntas;
            $_GET['pregunta_actual'] = 0;
        }

        $preguntas = $_GET['preguntas'];
        
        foreach ($preguntas as $key => $pregunta) {
            if ($key >= 3) {
                break;
            }

            $claseRespuesta = $key <= $_GET['pregunta_actual'] ? '' : 'bloqueada';
            echo "<div class='pregunta $claseRespuesta' id='pregunta" . $key . "'>";
            
            // AQUÍ LA PREGUNTA.
            echo "<h2 class = 'questiontitle'>{$pregunta['pregunta']}</h2>";
            echo "<div id='respuesta $claseRespuesta'>";
            
            foreach ($pregunta['respuestas'] as $answerKey => $respuesta) {
                $respuesta = str_replace(['+', '-', '*'], '', $respuesta);
                echo "<div class='respuesta $claseRespuesta' data-pregunta='$key' data-respuesta='$answerKey' data-correcta='" . $pregunta['respuesta_correcta'] . "' id='respuesta-$key-$answerKey' onclick=\"seleccionarRespuesta('$key', '$answerKey')\">$respuesta</div>";
            }
            
            echo "<button class='responder-btn' data-pregunta='$key' id='responder-btn-$key' disabled onclick=\"responderPregunta('$key', '$nivel_actual')\">Responder</button>";
            echo "</div>";
            echo "</div>";
        }
        
        $nivels = $_GET['nivel'];
        $nivels++;
        echo "<div class='ghof-buttons'>";
        echo "<button id='inicio-btn' onclick='regresarAlInicio()' style='display: none;' ><em><strong>Volver al inicio</em></strong></button>";
        echo "<button id='next-question' onclick='nextQuestion($nivels)' style='display: none;' >Siguiente pregunta</button>";
        echo "</div>"
        ?>
        </div>
        
        <audio id="correctSound" src="mp3/correct.mp3"></audio>
        <audio id="incorrectSound" src="mp3/fail.mp3"></audio>
        <script src="funciomGame.js"></script>
        <script src="funcionLanguage.js"></script>

        <footer class="footerinfo">
            <p>© MCM S.A.</p>
            <p>Contact us</p>
            <p>Follow us</p>
            <p>empresa@domini.cat</p>
            <p>twt ig p</p>
        </footer>

    </body>
</html>