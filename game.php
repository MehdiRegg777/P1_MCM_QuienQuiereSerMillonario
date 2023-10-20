<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Quiere ser millonario?</title>
    <style>
        .question-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
        }
        .question-box.hidden {
            display: none;
        }
        .respuesta {
            cursor: pointer;
        }
        .respuesta.seleccionada {
            background-color: #FFFF00; /* Cambia el color de fondo para indicar selección */
        }
    </style>
</head>
<body>
<?php
session_start();

// Función para obtener una pregunta aleatoria
function obtenerPreguntaAleatoria($preguntas) {
    return $preguntas[array_rand($preguntas)];
}

if (!isset($_SESSION['preguntas'])) {
    if (isset($_POST['language'])) {
        $language = $_POST['language']; // Obtener el idioma seleccionado
    } else {
        // Redirigir al usuario de vuelta a la página de inicio si no se proporcionó un idioma.
        header('Location: index.php');
        exit;
    }
    // Leer el contenido del archivo y dividirlo en preguntas
    $contenido = file_get_contents("questions/{$language}_1.txt");
    $lineas = explode("\n", $contenido);

    $preguntas = array();

    for ($i = 0; $i < count($lineas); $i += 5) {
        $pregunta = trim(substr($lineas[$i], 2)); // Extraer la pregunta
        $respuestas = array_map('trim', array_slice($lineas, $i + 1, 4)); // Extraer las respuestas

        // Modificar la lógica para obtener la respuesta correcta
        $respuestaCorrecta = array_search("+", $respuestas);
        $respuestas[$respuestaCorrecta] = str_replace('+', '', $respuestas[$respuestaCorrecta]);

        // Barajar las respuestas para mostrarlas en un orden aleatorio
        shuffle($respuestas);

        // Agregar la pregunta y respuestas al arreglo
        $preguntas[] = array(
            "pregunta" => $pregunta,
            "respuestas" => $respuestas,
            "respuesta_correcta" => $respuestaCorrecta,
        );
    }

    shuffle($preguntas); // Barajar las preguntas

    $_SESSION['preguntas'] = $preguntas;
    $_SESSION['pregunta_actual'] = 0; // Iniciar con la primera pregunta
}

$preguntas = $_SESSION['preguntas'];

if ($_SESSION['pregunta_actual'] === 3) {
    header("Location: win.php"); // Redirigir al usuario a la página de victoria
    exit;
}

foreach ($preguntas as $key => $pregunta) {
    echo '<div class="question-box';
    if ($key > $_SESSION['pregunta_actual']) {
        echo ' hidden'; // Ocultar preguntas no disponibles
    }
    echo '">';
    echo "<h2>{$pregunta['pregunta']}</h2>";
    echo "<div id='respuesta-container'>";
    foreach ($pregunta['respuestas'] as $answerKey => $respuesta) {
        echo "<div class='respuesta' data-pregunta='$key' data-respuesta='$answerKey'>$respuesta</div>";
    }
    echo "<button class='responder-btn' data-pregunta='$key' disabled>Responder</button>";
    echo "</div>";
    echo "</div>";
}
?>
<script>
    const respuestas = document.querySelectorAll('.respuesta');
    const responderBtns = document.querySelectorAll('.responder-btn');

    respuestas.forEach((respuesta) => {
        respuesta.addEventListener('click', () => {
            const preguntaIndex = respuesta.getAttribute('data-pregunta');
            respuestas.forEach((r) => r.classList.remove('seleccionada'));
            respuesta.classList.add('seleccionada');
            responderBtns[preguntaIndex].removeAttribute('disabled');
        });
    });

    responderBtns.forEach((responderBtn) => {
        responderBtn.addEventListener('click', () => {
            const preguntaIndex = responderBtn.getAttribute('data-pregunta');
            const respuestaSeleccionada = document.querySelector('.respuesta.seleccionada[data-pregunta="' + preguntaIndex + '"]');
            if (respuestaSeleccionada) {
                const respuestaCorrecta = '<?php echo $preguntas['preguntaIndex']['respuesta_correcta']; ?>';
                console.log(respuestaSeleccionada.getAttribute('data-respuesta') );
                console.log(respuestaCorrecta);

                if (respuestaSeleccionada.getAttribute('data-respuesta') === respuestaCorrecta.toString()) {
                alert('¡Felicidades! Respuesta correcta.');
                mostrarSiguientePregunta();
            } else {
                window.location.href = 'lose.php'; // Redirigir al usuario a la página de pérdida
}

            } else {
                alert('Por favor, selecciona una respuesta.');
            }
        });
    });

    function mostrarSiguientePregunta() {
        // Ocultar la pregunta actual
        const preguntaActual = document.querySelector('.question-box:not(.hidden)');
        preguntaActual.classList.add('hidden');

        // Mostrar la siguiente pregunta
        const siguientePregunta = document.querySelector('.question-box.hidden');
        if (siguientePregunta) {
            siguientePregunta.classList.remove('hidden');
        }
    }
</script>
</body>
</html>