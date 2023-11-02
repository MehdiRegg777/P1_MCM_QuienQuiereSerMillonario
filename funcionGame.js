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
function showMessage(message) {
    const messageElement = document.getElementById('message');
    messageElement.textContent = message;
    messageElement.style.display = 'block';
    setTimeout(function () {
        hideMessage();
    }, 4000);
}
function hideMessage() {
    const messageElement = document.getElementById('message');
    messageElement.style.display = 'none';
}

// CRONÓMETRO.
function startCountUpChronometer() {
    time++;
    const minutes = Math.floor(time / 60);
    const seconds = time % 60;
    const minutes00 = minutes < 10 ? "0" + minutes : minutes; // Es un if para mostrar 00:00 y no 0:0
    const second00 = seconds < 10 ? "0" + seconds : seconds;
    document.getElementById("timer").textContent = minutes00  + ":" + second00;
    let tiempo = minutes00  + ":" + second00;
    localStorage.setItem("time", time);
    saveSession('time=' + tiempo,'game.php');
}

let time = parseInt(localStorage.getItem("time")) || 0;
const intervalo = setInterval(startCountUpChronometer, 1000);

function resetChronometer() {
    const currentPage = window.location.pathname;
    if (currentPage === '/index.php' || currentPage === '/') {
        localStorage.removeItem('time');
        localStorage.removeItem('timeLeft');
      }
}

function reanudarChronometer() {
    let time = parseInt(localStorage.getItem("time"));
    startCountUpChronometer()
}

document.addEventListener('DOMContentLoaded', function () {
    resetChronometer();
});  

let intervalCountDown;
function updateCountDownChronometer() {
    const currentQuestion = document.querySelector(".pregunta:not(.bloqueada)"); //aqui obtengo la classe que tiene 'pregunta'
    const timerQuestion = currentQuestion.querySelector('.timerQuestion');
    if (timeLeft > 0) {
        timerQuestion.textContent = timeLeft;
        timeLeft--;
        localStorage.setItem('timeLeft', timeLeft);
        saveSession('timeLeft=' + timeLeft,'game.php');
    } else {
        timerQuestion.textContent = "Tiempo agotado";
        clearInterval(intervalCountDown);
        pageLose();
    }
}

function pageLose(){
    let niveles = document.querySelector(".nivel_actual");
    let nivel = niveles.getAttribute("nivelactual");
    console.log(calculoderespuesta(preguntaActual,nivel));
    calculateTotalPoints(calculoderespuesta(preguntaActual,nivel));
    const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'lose.php';
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'userpoints';
        input.value = calculoderespuesta(preguntaActual,nivel);
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
}

function startCountDownChronometer() {
    timeLeft = parseInt(localStorage.getItem("timeLeft")) || 30;
    intervalCountDown = setInterval(updateCountDownChronometer, 1000);
}
startCountDownChronometer();

function resetCountDownChronometer() {
    timeLeft = 30;
    const currentQuestion = document.querySelector(".pregunta:not(.bloqueada)");
    const timerQuestion = currentQuestion.querySelector('.timerQuestion');
    timerQuestion.textContent = timeLeft;
}

function stopCountDownChronometerReset() {
    clearInterval(intervalCountDown);
    const timerQuestion = 30;
    localStorage.setItem('timeLeft', timerQuestion);
}
function stopCountDownChronometerContinue() {
    clearInterval(intervalCountDown);
    const currentQuestion = document.querySelector(".pregunta:not(.bloqueada)");
    const timerQuestion = currentQuestion.querySelector('.timerQuestion');
    localStorage.setItem('timeLeft', timeLeft);
}

//
// COMODINES.
//
// COMODÍN 50%.
function button50() {
    
    const respuestaDesenfocada = document.querySelector(".respuesta:not(.bloqueada)");
    const respuestaCorrecta = respuestaDesenfocada.getAttribute("data-correcta");
    const respuestaNivel = respuestaDesenfocada.getAttribute("data-pregunta");
    const respuestasParaBloquear = [];

    // Genera un arreglo con dos respuestas incorrectas aleatorias
    while (respuestasParaBloquear.length < 2) {
        const numeroAleatorio = Math.floor(Math.random() * 4); // Suponiendo que hay 4 respuestas
        if (numeroAleatorio != respuestaCorrecta && !respuestasParaBloquear.includes(numeroAleatorio)) {
        respuestasParaBloquear.push(numeroAleatorio);
        }
    }

    for (let bucle = 0; bucle <= 3; bucle++) {
        const bloquearRespuestas = document.getElementById('respuesta-' + respuestaNivel + '-' + bucle);
        if (respuestasParaBloquear.includes(bucle)) {
          bloquearRespuestas.classList.add('bloqueada');
        }
    }
    const button50 = document.getElementById('buttonComodin50');
    button50.setAttribute('disabled', '');
    saveSession('comodin50=' + 'usado','game.php');
}

function buttonTime() {
    const buttonTime = document.getElementById('buttonComodinTime');
    buttonTime.setAttribute('disabled', '');
    saveSession('comodinTime=' + 'usado','game.php');
    timeLeft += 30;
    const timerQuestion = document.querySelector('.timerQuestion');
    timerQuestion.textContent = timeLeft;
    clearInterval(intervalCountDown);
    intervalCountDown = setInterval(updateCountDownChronometer, 1000);
};

function comodinPublico() {
    stopCountDownChronometerContinue();
    const respuestaDesenfocada = document.querySelector(".respuesta:not(.bloqueada)");
    const respuestaCorrecta = respuestaDesenfocada.getAttribute("data-correcta");
    const modal = document.getElementById('popupModal');
    const imagen = document.getElementById('popupImage');
    const probabilidad = Math.random();
    const imagenSrcPublico = 'imgs/publico.jpeg';
    const closeButton = document.querySelector('.close-button');
    const audioPopup = new Audio('mp3/epic.mp3');
    modal.style.display = "block";
    imagen.src = imagenSrcPublico;
    audioPopup.play();

    closeButton.addEventListener('click', function() {
        audioPopup.pause();
        audioPopup.currentTime = 0;
        modal.style.display = "none";
    });

    imagen.classList.add('scale-animation');

    setTimeout(function() {
        imagen.classList.remove('scale-animation');
        setTimeout(function() {
            const segundaImagen = new Image();
            segundaImagen.onload = function() {
                imagen.src = segundaImagen.src;
            };
            
            if (probabilidad <= 0.8) {
                segundaImagen.src = 'graficoBarras/' + respuestaCorrecta + '.png';
            } else {
                let respuestaIncorrecta;
                do {
                    respuestaIncorrecta = Math.floor(Math.random() * 4);
                } while (respuestaIncorrecta == respuestaCorrecta);
                segundaImagen.src = 'graficoBarras/' + respuestaIncorrecta + '.png';
            }
        }, 1000);
    }, 6000)

    const botonPublic0 = document.getElementById('boton-publico');
    botonPublic0.setAttribute('disabled', '');
    saveSession('comodinPublico=' + 'usado','game.php');
}

function cerrarImagen() {
    startCountDownChronometer();
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

// FIN COMODINES.

function seleccionarRespuesta(preguntaIndex, respuestaIndex) {
    const respuestaElement = document.getElementById('respuesta-' + preguntaIndex + '-' + respuestaIndex);

    if (respuestaElement && !respuestaElement.classList.contains('bloqueada')) {
        respuestaElement.classList.remove('bloqueada');
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
            playCorrectSound();
            showMessage(mensajes[language]['respuestaCorrecta']);
            respuestaSeleccionada.classList.remove('seleccionada');
            respuestaSeleccionada.classList.add('acertada');
            var numeroIndex = parseInt(preguntaIndex, 10);
            var preguntaIndexplus = numeroIndex + 1;
            scrollSiguientePregunta(preguntaIndexplus);
            mostrarSiguientePregunta(preguntaIndex, nivel, language);
            resetCountDownChronometer();
        } else {
            let puntos=calculoderespuesta(preguntaActual,nivel);
            playIncorrectSound();
            respuestaSeleccionada.classList.remove('seleccionada');
            respuestaSeleccionada.classList.add('fallada');
            showMessage(mensajes[language]['respuestaIncorrecta']);
            const btnResponder = document.getElementById('responder-btn-' + preguntaActual);
            btnResponder.setAttribute('disabled', '');
            calculateTotalPoints(puntos);
            const bloquearPregunta = document.getElementById('pregunta' + (preguntaActual));
            bloquearPregunta.classList.add('bloqueada');

            for (let bucle = 0; bucle <= 3; bucle++) {
                const bloquearRespuestas = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
                bloquearRespuestas.classList.add('bloqueada');
            }

            setTimeout(function () {
                const form = document.createElement('form');
                const input = document.createElement('input');
                form.method = 'POST';
                form.action = 'lose.php';
                input.type = 'hidden';
                input.name = 'userpoints';
                input.value = puntos;
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }, 4000);
        }
    } else {
        showMessage(mensajes[language]['seleccionaRespuesta']);
    };
}

function regresarAlInicio() {
    window.location.href = 'index.php'; // Redirect to the beginning
}

function nextQuestion(nivel){
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'game.php';

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'niveles';
    input.value = nivel;

    form.appendChild(input);
    document.body.appendChild(form);

    form.submit();
    //window.location.href = 'game.php?niveles=' + nivel;
    resetCountDownChronometer();
}

function mostrarSiguientePregunta(preguntaIndex, nivel, language) {
    preguntaActual2++;

    if (preguntaActual2 >= 3) {
        if (nivel <= 6) {
            nivel++;
            if (nivel <= 6) {

                const bloquearPregunta = document.getElementById('pregunta' + (preguntaActual));
                bloquearPregunta.classList.add('bloqueada');

                for (let bucle = 0; bucle <= 3; bucle++) {

                    const bloquearRespuestas = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
                    bloquearRespuestas.classList.add('bloqueada');
                }

                showMessage(mensajes[language]['subirNivel'] + nivel + '.');
                
                const next = document.getElementById("next-question");
                next.style.display = "";
                stopCountDownChronometerReset();
            } else {
                calculateTotalPoints(18)
                showMessage(mensajes[language]['juegoTerminado']);
                
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'win.php';

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'userpoints';
                input.value = '18';

                form.appendChild(input);
                document.body.appendChild(form);

                form.submit();
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

    saveSession('points=' + pointsTotal,'game.php');
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
    saveSession('buttonPublish=' + 'usado','lose.php');
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
    var startAudio = document.getElementById("winner");
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

function saveSession(id,direction) {
    fetch(direction, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: id,
    })
    .then(response => response.text())
    .then(data => {
        //console.log(data);
    });
};