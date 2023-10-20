

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
    <style>
        .question-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
        }
        .question-box.disabled {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
</head>
<body>
<div class="question-box">
    
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

        // Eliminar símbolos * - +
        $respuestas = array_map(function($respuesta) {
            return str_replace(['*', '-', '+'], '', $respuesta);
        }, $respuestas);

        // Agregar la pregunta y respuestas al arreglo
        $preguntas[] = array(
            "pregunta" => $pregunta,
            "respuestas" => $respuestas
        );
    }

    $_SESSION['preguntas'] = $preguntas;
}

// Obtén la pregunta actual de la sesión
if (isset($_SESSION['pregunta_actual'])) {
    $preguntaAleatoria = $_SESSION['pregunta_actual'];
} else {
    $preguntaAleatoria = obtenerPreguntaAleatoria($_SESSION['preguntas']);
    $_SESSION['pregunta_actual'] = $preguntaAleatoria;
}
function printarPregunta($preguntaAleatoria) {
    // Mostrar la pregunta y respuestas
    echo "<div class='question-box'>";
    echo "<h2>{$preguntaAleatoria['pregunta']}</h2>";
    foreach ($preguntaAleatoria['respuestas'] as $key => $respuesta) {
        echo "<input type='radio' name='respuesta' value='$respuesta' id='respuesta$key'> <label for='respuesta$key'>$respuesta</label><br>";
    }
    echo "<input type='hidden' name='pregunta' value='" . $preguntaAleatoria['pregunta'] . "'>";
    echo "<button onclick='comprobarRespuesta()'>Seleccionar Respuesta</button>";
    echo "</div>";
}

printarPregunta($preguntaAleatoria);

?>
<script>
    function comprobarRespuesta() {
        const respuestaCorrecta = '<?php echo $preguntaAleatoria['respuestas'][0]; ?>';
        console.log(respuestaCorrecta);
        const respuestaSeleccionada = document.querySelector('input[name="respuesta"]:checked');
        if (respuestaSeleccionada) {
            if (respuestaSeleccionada.value === respuestaCorrecta) {
                alert('¡Felicidades! Respuesta correcta.');

                // Deshabilitar la pregunta actual
                const preguntaActual = document.querySelector('.question-box');
                preguntaActual.classList.add('disabled');

                // Limpiar la pregunta actual de la sesión
                <?php unset($_SESSION['pregunta_actual']); ?>

                // Redirigir al usuario al inicio
            } else {
                alert('Respuesta incorrecta. La respuesta correcta era: ' + respuestaCorrecta);
                // Redirigir al usuario al inicio
                window.location.href = 'index.php';
            }
        } else {
            alert('Por favor, selecciona una respuesta.');
        }
    }
</script>
</body>
</html>
