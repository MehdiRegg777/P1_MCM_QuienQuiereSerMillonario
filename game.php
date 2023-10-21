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
// Verificar si es un nuevo juego o cargar el nivel actual desde la sesión
if (isset($_GET['niveles'])) {
    // Si se proporciona el parámetro 'nivel' en la URL, establecerlo en la variable de sesión
    $_SESSION['nivel'] = intval($_GET['niveles']);
} else {
    // Si no se proporciona el parámetro 'nivel' en la URL, establecer un valor predeterminado
    $_SESSION['nivel'] = 1;
}


$nivel_actual = $_SESSION['nivel'];

if (!isset($_SESSION['preguntas']) || isset($_GET['nuevo_juego'])) {
    // Cargar preguntas del nivel actual
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
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
?>
<script>
    const preguntas = <?php echo count($preguntas); ?>;
    let preguntaActual = 0;
    let preguntaActual2 = 0;
    // Función para iniciar el juego
    function empezarJuego() {
        document.getElementById('jugar-btn').style.display = 'none';
        document.getElementById('pregunta0').style.display = 'block';
        document.getElementById('responder-btn-0').removeAttribute('disabled');
    }

    function seleccionarRespuesta(preguntaIndex, respuestaIndex) {
        const respuestaElement = document.getElementById('respuesta-' + preguntaIndex + '-' + respuestaIndex);

        if (respuestaElement && !respuestaElement.classList.contains('bloqueada')) {
            // Quita la clase "bloqueada" del elemento
            respuestaElement.classList.remove('bloqueada');

            // Resto del código para la selección de respuesta y habilitar el botón de responder
            const respuestas = document.querySelectorAll('#pregunta' + preguntaIndex + ' .respuesta');
            respuestas.forEach((r) => r.classList.remove('seleccionada'));
            respuestaElement.classList.add('seleccionada');
            document.getElementById('responder-btn-' + preguntaIndex).removeAttribute('disabled');
        }
}


    function responderPregunta(preguntaIndex,respuestaIndex) {
    const respuestaSeleccionada = document.querySelector('#pregunta' + preguntaIndex + ' .respuesta.seleccionada');
    
    if (respuestaSeleccionada) {
        const respuestaElegida = respuestaSeleccionada.getAttribute('data-respuesta');
        const respuestaCorrecta = respuestaSeleccionada.getAttribute('data-correcta');

        if (respuestaElegida === respuestaCorrecta) {
            alert('¡Felicidades! Respuesta correcta.');
            respuestaSeleccionada.classList.remove('seleccionada'); // Desenfocar respuesta correcta
            mostrarSiguientePregunta(preguntaIndex,respuestaIndex);
        } else {
            alert('Respuesta incorrecta. Fin del juego.');
            console.log(respuestaElegida);
            console.log(respuestaCorrecta);
            // Habilita el botón de respuesta de la siguiente pregunta
            const desenfoqueResponder = document.getElementById('pregunta' + (preguntaActual ));
            desenfoqueResponder.classList.add('bloqueada');
            const bloquearboton = document.getElementById('responder-btn-' + preguntaActual);
            bloquearboton.setAttribute('disabled', '');
            for (let bucle = 0; bucle <= 3; bucle++) {

                const desenfoqueResponder = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
                desenfoqueResponder.classList.add('bloqueada');
            }
            document.body.innerHTML += "<button id='inicio-btn' onclick='regresarAlInicio()'>Volver al inicio</button>";


        }
    } else {
        alert('Por favor, selecciona una respuesta.');
    }
}
function regresarAlInicio() {
    window.location.href = 'index.php'; // Redirige al inicio
}


function mostrarSiguientePregunta(preguntaIndex,respuestaIndex) {
    preguntaActual2++;  

    if (preguntaActual2 >= 3) {
        let nivel = <?php echo $_SESSION['nivel']; ?>; // Obtener el valor de nivel de PHP en JavaScript
        if (nivel <= 6) {
            // Si el usuario ha respondido correctamente a 3 preguntas, aumentar el nivel
            nivel++;
           console.log(nivel);

           if (nivel <= 6) {
            // Recargar la página actual para cargar las preguntas del nuevo nivel
            alert('¡¡Ahora pasas al nivel: '+ nivel+'!!');
            window.location.href = 'game.php?niveles=' + nivel; 
            }else {
                // El usuario ha completado todos los niveles
                // Puedes mostrar un mensaje de finalización del juego o redirigir a la página principal.
                alert('¡Has respondido todas las preguntas! Juego terminado.');
                window.location.href = 'index.php'; // Redirigir a la página index.php
            }
}
    } 
    const preguntaActualElement = document.getElementById('pregunta' + preguntaActual);
    preguntaActualElement.style.display = ''; // Oculta la pregunta actual

    const bloquearboton = document.getElementById('responder-btn-' + preguntaActual);
    bloquearboton.setAttribute('disabled', '');

    // Habilita el botón de respuesta de la siguiente pregunta
    const desenfoqueResponder = document.getElementById('pregunta' + (preguntaActual ));
    desenfoqueResponder.classList.add('bloqueada');

    for (let bucle = 0; bucle <= 3; bucle++) {

        const desenfoqueResponder = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
        desenfoqueResponder.classList.add('bloqueada');
    }

//desenfocar la siguiete pregunta    
    const desenfoqueResponderSiguiente = document.getElementById('pregunta' + (preguntaActual + 1));
    desenfoqueResponderSiguiente.classList.remove('bloqueada');
    
// Habilita el botón de respuesta de la siguiente pregunta
    const btnResponderSiguiente = document.getElementById('responder-btn-' + (preguntaActual + 1));
    btnResponderSiguiente.removeAttribute('disabled'); // Habilita el botón de respuesta
    
    
    
    preguntaActual++;  
    preguntaIndex++;
    for (let bucle = 0; bucle <= 3; bucle++) {

    const desenfoqueResponder2 = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
    console.log(desenfoqueResponder2);
    desenfoqueResponder2.classList.remove('bloqueada');
    }

    
    
}


</script>
</body>
</html>