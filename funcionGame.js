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
        'respuestaCorrecta': 'Felicitats! Resposta correcta.',
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
        'juegoTerminado': 'You have answered all the questions! You\'ve finished the game.'
    }
};

// Algoritmo cronometro
function startCountUpChronometer() {
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
        body: 'time=' + tiempo,
    })
    .then(response => response.text())
    .then(data => {
        //console.log(data);
    });
}

// Inicializar el cronometro
let time = parseInt(localStorage.getItem("time")) || 0;
const intervalo = setInterval(startCountUpChronometer, 1000);

// Reiniciar el cronometro
function resetChronometer() {
    const currentPage = window.location.pathname;
    if (currentPage === '/index.php' || currentPage === '/') {
        localStorage.removeItem('time');
      }
}

// Reanudar cronometro
function reanudarChronometer() {
    let time = parseInt(localStorage.getItem("time"));
    startCountUpChronometer()
}

document.addEventListener('DOMContentLoaded', function () {
    resetChronometer();
});  


let tiempoRestante = 30;
function updateCountDownChronometer() {
    const timerQuestion = document.getElementById('timerQuestion');
  if (tiempoRestante > 0) {
    timerQuestion.textContent = tiempoRestante;
    tiempoRestante--;
  } else {
    timerQuestion.textContent = "Tiempo agotado";
    window.location.href = 'lose.php';
  }
}

function startCountDownChronometer() {
    const preguntaActual = document.querySelector('.pregunta:not(.bloqueada)'); // Selecciona la pregunta actual
    const timerQuestion = preguntaActual.querySelector('.timerQuestion'); // Encuentra el elemento timerQuestion dentro de la pregunta actual
    timerQuestion.style.display = "flex"; // Muestra el contador regresivo
    tiempoRestante = 30; // Reinicia el tiempo
    setInterval(updateCountDownChronometer, 1000);
}
startCountDownChronometer();

function resetCountDownChronometer() {
    tiempoRestante = 30;
    const timerQuestion = document.getElementById('timerQuestion');
    timerQuestion.textContent = tiempoRestante;
  }

function seleccionarRespuesta(preguntaIndex, respuestaIndex) {
    const respuestaElement = document.getElementById('respuesta-' + preguntaIndex + '-' + respuestaIndex);

    if (respuestaElement && !respuestaElement.classList.contains('bloqueada')) {
        // Remove the 'locked' class from the element
        respuestaElement.classList.remove('bloqueada');

        // The rest of the code for selecting the answer and enabling the respond button
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
        preguntaElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
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
            respuestaSeleccionada.classList.remove('seleccionada');
            respuestaSeleccionada.classList.add('acertada');
            var numeroIndex = parseInt(preguntaIndex, 10);
            var preguntaIndexplus = numeroIndex + 1;
            scrollSiguientePregunta(preguntaIndexplus);
            mostrarSiguientePregunta(preguntaIndex, nivel, language);
            resetCountDownChronometer()
        } else {
            let puntos=calculoderespuesta(preguntaActual,nivel);
            playIncorrectSound();

            respuestaSeleccionada.classList.remove('seleccionada');
            respuestaSeleccionada.classList.add('fallada');

            // Alert that the response is incorrect
            alert(mensajes[language]['respuestaIncorrecta']);

            // Enable the answer button for the next question
            const btnResponder = document.getElementById('responder-btn-' + preguntaActual);
            btnResponder.setAttribute('disabled', '');

            calculateTotalPoints(puntos);
            
            // Lock the question
            const bloquearPregunta = document.getElementById('pregunta' + (preguntaActual));
            bloquearPregunta.classList.add('bloqueada');

            // Lock the answers
            for (let bucle = 0; bucle <= 3; bucle++) {

                const bloquearRespuestas = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
                bloquearRespuestas.classList.add('bloqueada');
            }
            window.location.href = 'lose.php?puntage=' + puntos; 
        }
    } else {
        alert(mensajes[language]['seleccionaRespuesta']);
    };
    
    
}


// function comodinPublico2() {

//     const q1_is_answered = document.querySelector(".respuesta:not(.bloqueada)");
//     const dataCorrecta = q1_is_answered.getAttribute("data-correcta");
//     console.log(dataCorrecta);
// }

function comodinPublico(preguntaIndex) {
    const respuestaDesenfocada = document.querySelector(".respuesta:not(.bloqueada)");
    const respuestaCorrecta = respuestaDesenfocada.getAttribute("data-correcta");
    // const respuestaSeleccionada = document.querySelector('#pregunta' + preguntaIndex + ' .respuesta');
    // const respuestaCorrecta = respuestaSeleccionada.getAttribute('data-correcta');
    console.log(respuestaCorrecta);
    const modal = document.getElementById('popupModal');
    const imagen = document.getElementById('popupImage');

    const probabilidad = Math.random();

    if (probabilidad <= 0.8) {
        modal.style.display = "block";
        const imagenSrc = 'graficoBarras/'+ respuestaCorrecta + '.png';
        imagen.src = imagenSrc;
    }else {
        // Aquí mostraremos la incorrecta
        let respuestaIncorrecta;
        do {
            respuestaIncorrecta = Math.floor(Math.random() * 4); 
        } while (respuestaIncorrecta == respuestaCorrecta);

        console.log('Respuesta incorrecta: ' + respuestaIncorrecta);
        
        modal.style.display = "block";
        const imagenSrc = 'graficoBarras/'+ respuestaIncorrecta + '.png';
        imagen.src = imagenSrc;
    };
    const botonPublic0 = document.getElementById('boton-publico-0');
    botonPublic0.setAttribute('disabled', '');
    localStorage.setItem('boton-publico-0', botonPublic0);
    const botonPublic1 = document.getElementById('boton-publico-1');
    botonPublic1.setAttribute('disabled', '');
    const botonPublic2 = document.getElementById('boton-publico-2');
    botonPublic2.setAttribute('disabled', '');

}

function cerrarImagen() {
    const modal = document.getElementById('popupModal');
    modal.style.display = "none";
}

function calculoderespuesta(preguntaActual,nivel){
    let calculo;
    if (nivel == 1){

        return preguntaActual
        
    } if ((preguntaActual)== 3){
        return nivel*3
    } else {
        calculo = (nivel-1)*3
        calculo+=preguntaActual
        return calculo
    }
}

function regresarAlInicio() {
    window.location.href = 'index.php'; // Redirect to the beginning
}

function nextQuestion(nivel){
    window.location.href = 'game.php?niveles=' + nivel;
}

function mostrarSiguientePregunta(preguntaIndex, nivel, language) {
    preguntaActual2++;

    if (preguntaActual2 >= 3) {
        if (nivel <= 6) {
            nivel++;
            //console.log(nivel);

            if (nivel <= 6) {

                const bloquearPregunta = document.getElementById('pregunta' + (preguntaActual));
                bloquearPregunta.classList.add('bloqueada');

                for (let bucle = 0; bucle <= 3; bucle++) {

                    const bloquearRespuestas = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
                    bloquearRespuestas.classList.add('bloqueada');
                }

                alert(mensajes[language]['subirNivel'] + nivel + '.');
                // Parar cronometro
                
                const next = document.getElementById("next-question");
                next.style.display = "";
            } else {
                calculateTotalPoints(18)
                alert(mensajes[language]['juegoTerminado']);
                window.location.href = 'win.php?puntage=18';
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
        //console.log(desenfoqueSeguientesRespuestas);
        desenfoqueSeguientesRespuestas.classList.remove('bloqueada');
    }
}

function calculateTotalPoints(correctAnswer) {
    const tiempo = parseInt(localStorage.getItem("time")) || 0;

    let pointsTime = 0;
    if (tiempo >= 1 && tiempo <= 1200) {
        pointsTime = 1200 - tiempo + 1;
    } else{
        pointsTime = 0;
    }

    let pointsAnswer = 0;
    if (correctAnswer >= 1 && correctAnswer <= 18) {
        pointsAnswer = correctAnswer * 1300;
    }

    const pointsTotal = (correctAnswer === 0) ? 0 : pointsTime + pointsAnswer;

    fetch('lose.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'points=' + pointsTotal,
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
    });
}

// FUNCIONS DE SONS/CANÇONS.
function playCorrectSound() {
    var correctSound = document.getElementById("correctSound");
    correctSound.play();
}

function playIncorrectSound() {
    var incorrectSound = document.getElementById("incorrectSound");
    incorrectSound.play();
}

// FUNCIONES DE "PUBLISH".
function publishGame(){
    const mostrarFormulartio = document.getElementById("guardarpartida");
    mostrarFormulartio.style.display = "";
}

window.onload = function() {
    var gameover = document.getElementById('gameOver');
    gameover.play();
};

window.onload = function() {
    var startAudio = document.getElementById("start");
    startAudio.play();
};
window.onload = function() {
    var startAudio = document.getElementById("winerr");
    startAudio.play();
};

// FUNCIONES DE "FUNCIONLANGUAGE".
function changeLanguage(language) {
    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'language=' + language,
    })
    .then(response => response.text())
    .then(data => {
        window.location.reload();
    });
}

// COMPROBAR QUE EL USUARIO TIENE "JAVASCRIPT" ACTIVADO.
function demandJS(){

}

