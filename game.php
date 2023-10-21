<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Agregamos el CSS -->
    <style>
        .question-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
        }
        .respuesta {
            cursor: pointer;
        }
        .respuesta.bloqueada {
            background-color: #ccc;
            filter: blur(2px); /* Aplicamos el efecto de desenfoque */
            cursor: not-allowed; /* Cambiamos el cursor a "no permitido" */
        }
        .respuesta.seleccionada {
            background-color: #FFFF00;
        }
        .pregunta.bloqueada {
            background-color: #ccc;
            filter: blur(4px);
            cursor: not-allowed;
        }
    </style>
</head>
<body>
<?php
session_start();

if (!isset($_SESSION['preguntas']) || isset($_GET['nuevo_juego'])) {
    $contenido = file_get_contents('questions/spanish_1.txt');
    $lineas = explode("\n", $contenido);

    $preguntas = array();

    for ($i = 0; $i < count($lineas); $i += 5) {
        $pregunta = trim(substr($lineas[$i], 1));
        $respuestas = array_map('trim', array_slice($lineas, $i + 1, 4));

        $respuestaCorrecta = array_search("+", $respuestas);
        $respuestas[$respuestaCorrecta] = str_replace(['+', '-', '*'], '', $respuestas[$respuestaCorrecta]);

        shuffle($respuestas);

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

    $clasePregunta = $key <= $_SESSION['pregunta_actual'] ? '' : 'bloqueada';

    echo '<div class="question-box ' . $clasePregunta . '" id="pregunta' . $key . '">';
    echo "<h2>{$pregunta['pregunta']}</h2>";
    echo "<div id='respuesta-container'>";
    foreach ($pregunta['respuestas'] as $answerKey => $respuesta) {
        $respuesta = str_replace(['+', '-', '*'], '', $respuesta);
        $claseRespuesta = $key <= $_SESSION['pregunta_actual'] ? '' : 'bloqueada';
        echo "<div class='respuesta $claseRespuesta' data-pregunta='$key' data-respuesta='$answerKey' data-correcta='" . $pregunta['respuesta_correcta'] . "' id='respuesta-$key-$answerKey' onclick=\"seleccionarRespuesta('$key', '$answerKey')\">$respuesta</div>";
    }
    echo "<button class='responder-btn' data-pregunta='$key' id='responder-btn-$key' disabled onclick=\"responderPregunta('$key')\">Responder</button>";
    echo "</div>";
    echo "</div>";
}
?>
<script>
    const preguntas = <?php echo count($preguntas); ?>;
    let preguntaActual = 0;

    // Función para iniciar el juego
    function empezarJuego() {
        document.getElementById('jugar-btn').style.display = 'none';
        document.getElementById('pregunta0').style.display = 'block';
        document.getElementById('responder-btn-0').removeAttribute('disabled');
    }

    function seleccionarRespuesta(preguntaIndex, respuestaIndex) {
        
     
        const respuesta = document.getElementById('respuesta-' + preguntaIndex + '-' + respuestaIndex);
        console.log(respuesta);
        if (respuesta && !respuesta.classList.contains('bloqueada')) {
            const respuestas = document.querySelectorAll('#pregunta' + preguntaIndex + ' .respuesta');
            respuestas.forEach((r) => r.classList.remove('seleccionada'));
            respuesta.classList.add('seleccionada');
            document.getElementById('responder-btn-' + preguntaIndex).removeAttribute('disabled');
        }
    }

    function responderPregunta(preguntaIndex) {
    const respuestaSeleccionada = document.querySelector('#pregunta' + preguntaIndex + ' .respuesta.seleccionada');

    if (respuestaSeleccionada) {
        const respuestaElegida = respuestaSeleccionada.getAttribute('data-respuesta');
        const respuestaCorrecta = respuestaSeleccionada.getAttribute('data-correcta');
        
        if (respuestaElegida === respuestaCorrecta) {
            alert('¡Felicidades! Respuesta correcta.');
            mostrarSiguientePregunta();
        } else {
            alert('Respuesta incorrecta. Fin del juego.');
            console.log(respuestaElegida);
                console.log(respuestaCorrecta);
        }
    } else {
        alert('Por favor, selecciona una respuesta.');
    }
}



    function mostrarSiguientePregunta() {
        const preguntaActualElement = document.getElementById('pregunta' + preguntaActual);
        preguntaActualElement.style.display = 'none';

        preguntaActual++;
        if (preguntaActual < preguntas) {
            const siguientePregunta = document.getElementById('pregunta' + preguntaActual);
            siguientePregunta.style.display = 'block';
            document.getElementById('responder-btn-' + preguntaActual).removeAttribute('disabled');
        } else {
            alert('¡Has respondido todas las preguntas! Juego terminado.');
        }
    }
</script>
</body>
</html>
