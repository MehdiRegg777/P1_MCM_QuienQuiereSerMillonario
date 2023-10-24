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

function scrollSiguientePregunta(preguntaIndex) {
    const preguntaId = 'pregunta' + preguntaIndex;
    const preguntaElement = document.getElementById(preguntaId);
    
    if (preguntaElement) {
        preguntaElement.scrollIntoView({ behavior: 'smooth' });
    }
}

function responderPregunta(preguntaIndex, nivel) {
    const respuestaSeleccionada = document.querySelector('#pregunta' + preguntaIndex + ' .respuesta.seleccionada');

    if (respuestaSeleccionada) {
        const respuestaElegida = respuestaSeleccionada.getAttribute('data-respuesta');
        const respuestaCorrecta = respuestaSeleccionada.getAttribute('data-correcta');

        if (respuestaElegida === respuestaCorrecta) {

            playCorrectSound();

            alert('¡Felicidades! Respuesta correcta.');
            respuestaSeleccionada.classList.remove('seleccionada'); // Quitar la seleccion amarilla al acertar
            respuestaSeleccionada.classList.add('acertada'); // Y poner la seleccion en verde
            scrollSiguientePregunta(preguntaIndex);
            mostrarSiguientePregunta(preguntaIndex, nivel);
        } else {
            // console.log(respuestaElegida);
            // console.log(respuestaCorrecta);
            let puntos=calculoderespuesta(preguntaActual,nivel);
            playIncorrectSound();

            respuestaSeleccionada.classList.remove('seleccionada'); // Quitar la seleccion amarilla al acertar
            respuestaSeleccionada.classList.add('fallada'); // Y poner la seleccion en rojo

            //Alerte de que la respuesta es incorecta
            alert('Respuesta incorrecta. Fin del juego.');

            // Habilita el botón de respuesta de la siguiente pregunta
            const btnResponder = document.getElementById('responder-btn-' + preguntaActual);
            btnResponder.setAttribute('disabled', '');

            //
            
            //Bloquear la pregunta
            const bloquearPregunta = document.getElementById('pregunta' + (preguntaActual));
            bloquearPregunta.classList.add('bloqueada');

            //Bloquear respuestas
            for (let bucle = 0; bucle <= 3; bucle++) {

                const bloquearRespuestas = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
                bloquearRespuestas.classList.add('bloqueada');
            }

            //ir a la pagin lose
            window.location.href = 'lose.php?puntage=' + puntos; 
            
            
            //document.body.innerHTML += "";
            /////

        }
    } else {
        alert('Por favor, selecciona una respuesta.');
    }
}

function calculoderespuesta(preguntaActual,nivel){
    let calculo;
    if (nivel == 1){
        return preguntaActual+1
    }if ((preguntaActual+1)== 3){
        return nivel*3
    }else {
        calculo = (nivel-1)*3
        calculo+=preguntaActual+1
        return calculo
    }
    

}

function regresarAlInicio() {
    window.location.href = 'index.php'; // Redirige al inicio
}

function nextQuestion(nivel){
    window.location.href = 'game.php?niveles=' + nivel;
}


function mostrarSiguientePregunta(preguntaIndex, nivel) {
    preguntaActual2++;

    if (preguntaActual2 >= 3) {
        if (nivel <= 6) {
            // Si el usuario ha respondido correctamente a 3 preguntas, aumentar el nivel
            nivel++;
            console.log(nivel);

            if (nivel <= 6) {

                //Bloquear la pregunta
                const bloquearPregunta = document.getElementById('pregunta' + (preguntaActual));
                bloquearPregunta.classList.add('bloqueada');

                //Bloquear respuestas
                for (let bucle = 0; bucle <= 3; bucle++) {

                    const bloquearRespuestas = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
                    bloquearRespuestas.classList.add('bloqueada');
                }

                // Recargar la página actual para cargar las preguntas del nuevo nivel
                alert('Ahora subirá el nivel de dificultad a ' + nivel + '.');

                //Insertar el boton para volver al inicio despues de perder
                const backIndex = document.getElementById("inicio-btn");
                backIndex.style.display = "";

                //Insertar el boton para ir a la pagina siguintes preguntas
                const next = document.getElementById("next-question");
                next.style.display = "";
                //document.body.innerHTML += "<button id='next-question' onclick='nextQuestion("+nivel+")' ' >Siguiente pregunta</button>";
            } else {
                // El usuario ha completado todos los niveles
                // Puedes mostrar un mensaje de finalización del juego o redirigir a la página principal.
                alert('¡Has respondido todas las preguntas! Juego terminado.');
                window.location.href = 'win.php?puntage=18'; // Redirigir a la página win.php
            }
        }
    }


    // Habilita el botón de respuesta de la siguiente pregunta
    const btnResponder = document.getElementById('responder-btn-' + preguntaActual);
    btnResponder.setAttribute('disabled', '');

    //

    //Bloquear la pregunta
    const bloquearPregunta = document.getElementById('pregunta' + (preguntaActual));
    bloquearPregunta.classList.add('bloqueada');

    //Bloquear respuestas
    for (let bucle = 0; bucle <= 3; bucle++) {

        const bloquearRespuestas = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
        bloquearRespuestas.classList.add('bloqueada');
    }

    //desenfocar la siguiete pregunta    
    const desenfoqueSiguientePregunta = document.getElementById('pregunta' + (preguntaActual + 1));
    desenfoqueSiguientePregunta.classList.remove('bloqueada');

    preguntaActual++;
    preguntaIndex++;

    //Desenfocar siguientes respuestas
    for (let bucle = 0; bucle <= 3; bucle++) {

        const desenfoqueSeguientesRespuestas = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
        console.log(desenfoqueSeguientesRespuestas);
        desenfoqueSeguientesRespuestas.classList.remove('bloqueada');
    }



}

// Función para reproducir el sonido correcto
function playCorrectSound() {
    var correctSound = document.getElementById("correctSound");
    correctSound.play();
}
// Función para reproducir el sonido incorrecto
function playIncorrectSound() {
    var incorrectSound = document.getElementById("incorrectSound");
    incorrectSound.play();
}
