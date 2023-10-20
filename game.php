

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    
    <title>¿Quién quiere ser millonario?</title>
</head>
<body>
    <?php
    function readQuestions($language) {
        $route = "questions/" . $language . ".txt";
        $content = file($route, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        echo "<p>{$content[0]}</p>";
        return $content;
    }

    function getRandomNumber($questions) {
        $longitud = count($questions);
        $numerosMultiplos = array();
    
        for ($i = 0; $i < $longitud; $i++) {
            if ($i % 5 == 0) {
                $numerosMultiplos[] = $i;
            }
        }
    
        $indiceAleatorio = array_rand($numerosMultiplos);
        return $numerosMultiplos[$indiceAleatorio];
    }

    function printQuestions($questions, $indice) {
        if ($indice < count($questions) - 4) {
            echo "<h1>" . $questions[$indice] . "</h1></br>";
            for ($i = $indice + 1; $i <= $indice + 4; $i++) {
                echo $questions[$i] . "</br>";
            }
            //echo $questions[$indice + 5] . "\n";
        } else {
            echo "Índice fuera de rango.\n";
        }
    }

    /* readQuestions('catalan_1.txt');
    function selectQuestions($question){

    } */

    /* function selectQuestions($questions, $amount) {
        $selectedQuestions = array_rand($questions, $amount);
        echo "<p>{$selectedQuestions[0]}</p>";
        echo "<p>{$selectedQuestions[1]}</p>";
        echo "<p>{$selectedQuestions[2]}</p>";
        $prueba = array_intersect_key($questions, array_flip($selectedQuestions));
        echo "<p>{$prueba}</p>";
        return array_intersect_key($questions, array_flip($selectedQuestions));
    } */
    /* selectQuestions(readQuestions('catalan_1.txt'),3);
    function printQuestion($question) {
        list($textoPregunta, $opciones) = explode("*", $question, 2);
        $opciones = explode('-', $opciones);
        
        echo "<p>{$textoPregunta}</p>";
        
        foreach ($opciones as $opcion) {
            echo "<input type='radio' name='respuesta' value='{$opcion}'> {$opcion}<br>";
        }
    } */
    
    $questions = readQuestions('catalan_1');
    //$selectedQuestion = selectQuestions($questions, 3);
    
    $selectedQuestion = getRandomNumber($questions);

    printQuestions($questions, $selectedQuestion);

    ?>

    <h1>¿Quién quiere ser millonario?</h1>
    <form action="game.php" method="post">
        <?php printQuestion(current($selectedQuestion)); ?>
        <input type="submit" name="siguiente" value="Siguiente Pregunta">
    </form>

    <?php
    if (isset($_POST['siguiente'])) {
        next($selectedQuestion);
        if (current($selectedQuestion)) {
            printQuestion(current($selectedQuestion));
        } else {
            echo "<p>¡Nivel completado!</p>";
        }
    }

    ?>
=======
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
    // Leer el contenido del archivo y dividirlo en preguntas
    $contenido = file_get_contents('questions/spanish_1.txt');
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
>>>>>>> origin/Mehdi
</body>
</html>