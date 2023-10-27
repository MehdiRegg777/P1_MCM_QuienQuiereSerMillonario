let preguntaActual = 0;
let preguntaActual2 = 0;
const mensajes = {
    'spanish': {
        'respuestaCorrecta': '¡Felicidades! Respuesta correcta.',
        'respuestaIncorrecta': 'Respuesta incorrecta. Fin del juego.',
        'seleccionaRespuesta': 'Por favor, selecciona una respuesta.',
        'subirNivel': 'Ahora subirá el nivel de dificultad a ',
        'juegoTerminado': '¡Has respondido todas las preguntas! Juego terminado.'
    },
    'catalan': {
        'respuestaCorrecta': '¡Felicitats! Resposta correcta.',
        'respuestaIncorrecta': 'Resposta incorrecta. Fi del joc.',
        'seleccionaRespuesta': 'Si us plau, seleccioneu una resposta.',
        'subirNivel': 'Ara pujarà el nivell de dificultat a ',
        'juegoTerminado': 'Has respost totes les preguntes! Joc acabat.'
    },
    'english': {
        'respuestaCorrecta': 'Congratulations! Correct answer.',
        'respuestaIncorrecta': 'Incorrect answer. End of the game.',
        'seleccionaRespuesta': 'Please select an answer.',
        'subirNivel': 'Now it will increase the difficulty level to ',
        'juegoTerminado': 'You have answered all the questions! Game over.'
    }
};

// Algoritmo cronometro
function startChronometer() {
    time++;
    const minutes = Math.floor(time / 60);
    const seconds = time % 60;
    const minutes00 = minutes < 10 ? "0" + minutes : minutes; // Es un if para mostrar 00:00 y no 0:0
    const second00 = seconds < 10 ? "0" + seconds : seconds;
    document.getElementById("timer").textContent = minutes00  + ":" + second00;
    let tiempo = minutes00  + ":" + second00;
    localStorage.setItem("time", time);
    fetch('game.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'timee=' + encodeURIComponent(tiempo),
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
    });
}

// Inicializar el cronometro
let time = parseInt(localStorage.getItem("time")) || 0;
const intervalo = setInterval(startChronometer, 1000);

// Reiniciar el cronometro
function reiniciarChronometer() {
    const currentPage = window.location.pathname;
    if (currentPage === '/index.php' || currentPage === '/') {
        localStorage.removeItem('time');
      }
}

document.addEventListener('DOMContentLoaded', function () {
    reiniciarChronometer();
  });  

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

function responderPregunta(preguntaIndex, nivel, language) {
    const respuestaSeleccionada = document.querySelector('#pregunta' + preguntaIndex + ' .respuesta.seleccionada');

    if (respuestaSeleccionada) {
        const respuestaElegida = respuestaSeleccionada.getAttribute('data-respuesta');
        const respuestaCorrecta = respuestaSeleccionada.getAttribute('data-correcta');

        if (respuestaElegida === respuestaCorrecta) {
            //console.log(idioma);
            playCorrectSound();

            alert(mensajes[language]['respuestaCorrecta']);
            respuestaSeleccionada.classList.remove('seleccionada'); // Quitar la seleccion amarilla al acertar
            respuestaSeleccionada.classList.add('acertada'); // Y poner la seleccion en verde
            scrollSiguientePregunta(preguntaIndex);
            mostrarSiguientePregunta(preguntaIndex, nivel, language);
        } else {
            // console.log(respuestaElegida);
            // console.log(respuestaCorrecta);
            let puntos=calculoderespuesta(preguntaActual,nivel);
            playIncorrectSound();

            respuestaSeleccionada.classList.remove('seleccionada'); // Quitar la seleccion amarilla al acertar
            respuestaSeleccionada.classList.add('fallada'); // Y poner la seleccion en rojo

            //Alerte de que la respuesta es incorecta
            alert(mensajes[language]['respuestaIncorrecta']);

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

            // Calcular puntos obtenidos por respuesta

            //ir a la pagin lose
            window.location.href = 'lose.php?puntage=' + puntos; 
            
            
            //document.body.innerHTML += "";
            /////

        }
    } else {
        alert(mensajes[language]['seleccionaRespuesta']);
    }
}

function calculoderespuesta(preguntaActual,nivel){
    let calculo;
    if (nivel == 1){

        return preguntaActual
        
    }if ((preguntaActual)== 3){
        return nivel*3
    }else {
        calculo = (nivel-1)*3
        calculo+=preguntaActual
        return calculo
    }
    

}

function regresarAlInicio() {
    window.location.href = 'index.php'; // Redirige al inicio
}

function nextQuestion(nivel){
    window.location.href = 'game.php?niveles=' + nivel;
}


function mostrarSiguientePregunta(preguntaIndex, nivel, language) {
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
                alert(mensajes[language]['subirNivel'] + nivel + '.');
                // Parar cronometro
                //Insertar el boton para volver al inicio despues de perder
                // const backIndex = document.getElementById("inicio-btn");
                // backIndex.style.display = "";

                //Insertar el boton para ir a la pagina siguintes preguntas
                const next = document.getElementById("next-question");
                next.style.display = "";
                //document.body.innerHTML += "<button id='next-question' onclick='nextQuestion("+nivel+")' ' >Siguiente pregunta</button>";
            } else {
                // El usuario ha completado todos los niveles
                // Puedes mostrar un mensaje de finalización del juego o redirigir a la página principal.
                alert(mensajes[language]['juegoTerminado']);
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
