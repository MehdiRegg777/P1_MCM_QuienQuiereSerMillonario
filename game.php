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
        <header>
            <h1>¿Quién quiere ser millonario?</h1>
        </header>
        
        <?php
        
        if (isset($_GET['niveles'])) {
            $_SESSION['nivel'] = intval($_GET['niveles']);
        } else {
            $_SESSION['nivel'] = 1;
        }

        $nivel_actual = $_SESSION['nivel'];

        if (!isset($_SESSION['preguntas']) || isset($_GET['nuevo_juego'])) {
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
            $_SESSION['preguntas'] = $preguntas;
            $_SESSION['pregunta_actual'] = 0;
        }

        $preguntas = $_SESSION['preguntas'];
        
        foreach ($preguntas as $key => $pregunta) {
            if ($key >= 3) {
                break;
            }

            $claseRespuesta = $key <= $_SESSION['pregunta_actual'] ? '' : 'bloqueada';
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
        
        $nivels = $_SESSION['nivel'];
        $nivels++;
        echo "<button id='inicio-btn' onclick='regresarAlInicio()' style='display: none;' ><em><strong>Volver al inicio</em></strong></button>";
        echo "<button id='next-question' onclick='nextQuestion($nivels)' style='display: none;' >Siguiente pregunta</button>";
        ?>
        
        <audio id="correctSound" src="mp3/correct.mp3"></audio>
        <audio id="incorrectSound" src="mp3/fail.mp3"></audio>
        <script src="funciomGame.js"></script>

        <footer class="footerinfo">
            <p>© MCM S.A.</p>
            <p>Contact us</p>
            <p>Follow us</p>
            <p>empresa@domini.cat</p>
            <p>twt ig p</p>
        </footer>

    </body>
</html>