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
        echo "<h2>{$pregunta['pregunta']}</h2>";

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
    echo "<button id='inicio-btn' onclick='regresarAlInicio()' style='display: none;' >Volver al inicio</button>";
    echo "<button id='next-question' onclick='nextQuestion($nivels)' style='display: none;' >Siguiente pregunta</button>";
    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>";

    ?>
    <audio id="correctSound" src="mp3/correct.mp3"></audio>
    <audio id="incorrectSound" src="mp3/fail.mp3"></audio>
    <script src="funciomGame.js"></script>

</body>

                            const bloquearPregunta = document.getElementById('pregunta' + (preguntaActual));
                            bloquearPregunta.classList.add('bloqueada');

                            for (let bucle = 0; bucle <= 3; bucle++) {

                                const bloquearRespuestas = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
                                bloquearRespuestas.classList.add('bloqueada');
                            }

                            alert('Ahora pasas al nivel: ' + nivel + '.');
                            const next = document.getElementById("next-question");
                            next.style.display = "";
                        } else {
                            alert('¡Has respondido todas las preguntas! Juego terminado.');
                            window.location.href = 'index.php';
                        }
                    }
                }

                const btnResponder = document.getElementById('responder-btn-' + preguntaActual);
                btnResponder.setAttribute('disabled', '');

                const bloquearPregunta = document.getElementById('pregunta' + (preguntaActual));
                bloquearPregunta.classList.add('bloqueada');

                for (let bucle = 0; bucle <= 3; bucle++) {

                    const bloquearRespuestas = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
                    bloquearRespuestas.classList.add('bloqueada');
                }

                const desenfoqueSiguientePregunta = document.getElementById('pregunta' + (preguntaActual + 1));
                desenfoqueSiguientePregunta.classList.remove('bloqueada');

                preguntaActual++;
                preguntaIndex++;

                for (let bucle = 0; bucle <= 3; bucle++) {
                    const desenfoqueSeguientesRespuestas = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
                    console.log(desenfoqueSeguientesRespuestas);
                    desenfoqueSeguientesRespuestas.classList.remove('bloqueada');
                }
            }

    // SONIDO.
            function playCorrectSound() {
                var correctSound = document.getElementById("correctSound");
                correctSound.play();
    }

            function playIncorrectSound() {
                var incorrectSound = document.getElementById("incorrectSound");
                incorrectSound.play();
    }
        </script>
    </body>
</html>