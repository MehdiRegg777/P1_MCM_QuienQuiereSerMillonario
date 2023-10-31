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
    saveSession('time=' + tiempo);
}

let time = parseInt(localStorage.getItem("time")) || 0;
const intervalo = setInterval(startCountUpChronometer, 1000);

function reiniciarChronometer() {
    const currentPage = window.location.pathname;
    if (currentPage === '/index.php' || currentPage === '/') {
        localStorage.removeItem('time');
        localStorage.removeItem('timeLeft');
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

// Algoritmo cronometro inverso
let timeLeft = parseInt(localStorage.getItem("timeLeft")) || 30;
function updateCountDownChronometer() {
    const timerQuestion = document.getElementById('timerQuestion');
  if (timeLeft > 0) {
    timerQuestion.textContent = timeLeft;
    timeLeft--;
    localStorage.setItem('timeLeft', timeLeft);
    saveSession('timeLeft=' + timeLeft);
  } else {
    timerQuestion.textContent = "Tiempo agotado";
    window.location.href = 'lose.php';
  }
}
// Inicializar el cronometro inverso
function startCountDownChronometer() {
    //const preguntaActual = document.querySelector('.pregunta:not(.bloqueada)'); // Selecciona la pregunta actual
    //const timerQuestion = preguntaActual.querySelector('.timerQuestion'); // Encuentra el elemento timerQuestion dentro de la pregunta actual
    //timerQuestion.style.display = "flex"; // Muestra el contador regresivo
    timeLeft = parseInt(localStorage.getItem("timeLeft")) || 30;
    setInterval(updateCountDownChronometer, 1000);
}
startCountDownChronometer();

function resetCountDownChronometer() {
    timeLeft = 30;
    const timerQuestion = document.getElementById('timerQuestion');
    timerQuestion.textContent = timeLeft;
}

function buttonTime() {
    timeLeft += 30;
    const timerQuestion = document.querySelector('.timerQuestion');
    timerQuestion.textContent = timeLeft;

    intervalo = setInterval(updateCountDownChronometer, 1000); // Reinicia el contador
};


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

            alert(mensajes[language]['respuestaIncorrecta']);

            const btnResponder = document.getElementById('responder-btn-' + preguntaActual);
            btnResponder.setAttribute('disabled', '');

            calculateTotalPoints(puntos);
            
            // Lock the question
            const bloquearPregunta = document.getElementById('pregunta' + (preguntaActual));
            bloquearPregunta.classList.add('bloqueada');

            for (let bucle = 0; bucle <= 3; bucle++) {

                const bloquearRespuestas = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
                bloquearRespuestas.classList.add('bloqueada');
            }
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'lose.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'userpoints';
            input.value = puntos;

            form.appendChild(input);
            document.body.appendChild(form);

            form.submit();
            //window.location.href = 'lose.php?userpoints=' + puntos; 
        }
    } else {
        alert(mensajes[language]['seleccionaRespuesta']);
    };
    
    
}




function comodinPublico() {
    //Obtener la respuesta correcta a traves de la respuestas que estan desenfocadas
    const respuestaDesenfocada = document.querySelector(".respuesta:not(.bloqueada)");
    const respuestaCorrecta = respuestaDesenfocada.getAttribute("data-correcta");
   
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
    const botonPublic0 = document.getElementById('boton-publico');
    botonPublic0.setAttribute('disabled', '');
    
    saveSession('comodinPublico=' + 'usado');

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
    window.location.href = 'index.php';
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

    saveSession('points=' + pointsTotal);
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

function saveSession(id) {
    fetch('game.php', {
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

// COMPROBAR QUE EL USUARIO TIENE "JAVASCRIPT" ACTIVADO.
function demandJS(){

}

/* COMODÍN 50% */
var comodinUsado = false;

document.getElementById("comodin-50").addEventListener("click", function () {
    if (!comodinUsado) {
        comodinUsado = true;

        var respuestas = document.querySelectorAll(".respuesta");

        var respuestasDeshabilitadas = 0;
        for (var i = 0; i < respuestas.length; i++) {
            if (!respuestas[i].classList.contains("respuesta-correcta")) {
                respuestas[i].disabled = true;
                respuestasDeshabilitadas++;
                if (respuestasDeshabilitadas >= 2) {
                    break;
                }}}
        this.disabled = true;
    }
});
