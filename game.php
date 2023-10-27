<?php
    session_start();
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
                    echo "<a href='/index.php'><h1>Who wants to be a millonarie</h1></a>";
                }

        echo "</header>";
        
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
        }
        }

        if (isset($_GET['niveles'])) {
            $_GET['nivel'] = intval($_GET['niveles']);
        } else {
            $_GET['nivel'] = 1;
        }

        $nivel_actual = $_GET['nivel'];

        if (!isset($_GET['preguntas']) || isset($_GET['nuevo_juego'])) {
            $contenido = file_get_contents("questions/{$_SESSION['language']}_$nivel_actual.txt");
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
            echo "<h2 class = 'questiontitle'>{$pregunta['pregunta']}</h2>";
            echo "<div id='respuesta $claseRespuesta'>";
            
            foreach ($pregunta['respuestas'] as $answerKey => $respuesta) {
                $respuesta = str_replace(['+', '-', '*'], '', $respuesta);
                echo "<div class='respuesta $claseRespuesta' data-pregunta='$key' data-respuesta='$answerKey' data-correcta='" . $pregunta['respuesta_correcta'] . "' id='respuesta-$key-$answerKey' onclick=\"seleccionarRespuesta('$key', '$answerKey')\">$respuesta</div>";
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
        
        $nivels = $_GET['nivel'];
        $nivels++;
        echo "<div class='ghof-buttons'>";

        if ($_SESSION['language'] === 'spanish') {
            echo "<button id='next-question' onclick='nextQuestion($nivels)' style='display: none;' >Siguiente pregunta</button>";
        } elseif ($_SESSION['language'] === 'catalan') {
            echo "<button id='next-question' onclick='nextQuestion($nivels)' style='display: none;' >Següent pregunta</button>";
        } elseif ($_SESSION['language'] === 'english') {
            echo "<button id='next-question' onclick='nextQuestion($nivels)' style='display: none;' >Next question</button>";
        }
        echo "</div>"
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