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
            echo "<h2>{$pregunta['pregunta']}</h2>";

            echo "<div id='respuesta $claseRespuesta'>";
            foreach ($pregunta['respuestas'] as $answerKey => $respuesta) {
                $respuesta = str_replace(['+', '-', '*'], '', $respuesta);
                echo "<div class='respuesta $claseRespuesta' data-pregunta='$key' data-respuesta='$answerKey' data-correcta='" . $pregunta['respuesta_correcta'] . "' id='respuesta-$key-$answerKey' onclick=\"seleccionarRespuesta('$key', '$answerKey')\">$respuesta</div>";
            }
            echo "<button class='responder-btn' data-pregunta='$key' id='responder-btn-$key' disabled onclick=\"responderPregunta('$key', '$answerKey')\">Responder</button>";
            echo "</div>";
            echo "</div>";
        }
        $nivels = $_SESSION['nivel'];
        $nivels++;
        echo "<button id='inicio-btn' onclick='regresarAlInicio()' style='display: none;' >Volver al inicio</button>";
        echo "<button id='next-question' onclick='nextQuestion($nivels)' style='display: none;' >Siguiente pregunta</button>";
        ?>

        <audio id="correctSound" src="mp3/correct.mp3"></audio>
        <audio id="incorrectSound" src="mp3/fail.mp3"></audio>



        <script>
            const preguntas = <?php echo count($preguntas); ?>;
            let preguntaActual = 0;
            let preguntaActual2 = 0;

        
            function empezarJuego() {
                document.getElementById('jugar-btn').style.display = 'none';
                document.getElementById('pregunta0').style.display = 'block';
                document.getElementById('responder-btn-0').removeAttribute('disabled');
            }

            function seleccionarRespuesta(preguntaIndex, respuestaIndex) {
                const respuestaElement = document.getElementById('respuesta-' + preguntaIndex + '-' + respuestaIndex);

                if (respuestaElement && !respuestaElement.classList.contains('bloqueada')) {
                    respuestaElement.classList.remove('bloqueada');

                    const respuestas = document.querySelectorAll('#pregunta' + preguntaIndex + ' .respuesta');
                    respuestas.forEach((r) => r.classList.remove('seleccionada'));
                    respuestaElement.classList.add('seleccionada');
                    document.getElementById('responder-btn-' + preguntaIndex).removeAttribute('disabled');
                }}

            function responderPregunta(preguntaIndex, respuestaIndex) {
                const respuestaSeleccionada = document.querySelector('#pregunta' + preguntaIndex + ' .respuesta.seleccionada');

                if (respuestaSeleccionada) {
                    const respuestaElegida = respuestaSeleccionada.getAttribute('data-respuesta');
                    const respuestaCorrecta = respuestaSeleccionada.getAttribute('data-correcta');

                    if (respuestaElegida === respuestaCorrecta) {

                        playCorrectSound();

                        alert('¡Felicidades! Respuesta correcta.');
                        respuestaSeleccionada.classList.remove('seleccionada');
                        respuestaSeleccionada.classList.add('acertada');

                        mostrarSiguientePregunta(preguntaIndex, respuestaIndex);
                    } else {
                        playIncorrectSound();
                        respuestaSeleccionada.classList.remove('seleccionada');
                        respuestaSeleccionada.classList.add('fallada');
                        alert('Respuesta incorrecta. Fin del juego.');
                        const btnResponder = document.getElementById('responder-btn-' + preguntaActual);
                        btnResponder.setAttribute('disabled', '');
                        const bloquearPregunta = document.getElementById('pregunta' + (preguntaActual));
                        bloquearPregunta.classList.add('bloqueada');

                        for (let bucle = 0; bucle <= 3; bucle++) {
                            const bloquearRespuestas = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
                            bloquearRespuestas.classList.add('bloqueada');
                        }
                        
                        const backIndex = document.getElementById("inicio-btn");
                        backIndex.style.display = "";
                    }
                } else {
                    alert('Por favor, selecciona una respuesta.');
                }
            }

            function regresarAlInicio() {
                window.location.href = 'index.php';
            }

            function nextQuestion(nivel){
                window.location.href = 'game.php?niveles=' + nivel;
            }


            function mostrarSiguientePregunta(preguntaIndex, respuestaIndex) {
                preguntaActual2++;

                if (preguntaActual2 >= 3) {
                    let nivel = <?php echo $_SESSION['nivel']; ?>;
                    if (nivel <= 6) {
                        nivel++;
                        console.log(nivel);

                        if (nivel <= 6) {

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