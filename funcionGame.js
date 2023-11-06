let preguntaActual = 0;
let preguntaActual2 = 0;

const mensajes = {
    'spanish': {
        'respuestaCorrecta': '¡Felicidades! Respuesta correcta.',
        'respuestaIncorrecta': 'Respuesta incorrecta. Fin del juego.',
        'tiempoAgotado': 'Tiempo agotado. Fin del juego.',
        'seleccionaRespuesta': 'Por favor, selecciona una respuesta.',
        'subirNivel': 'Ahora subirá el nivel de dificultad a ',
        'juegoTerminado': '¡Has respondido todas las preguntas! Juego terminado.',
        'palabraInapropiada': '¡IMPOSIBLE! El nombre contiene una palabra inadecuada: '
    },
    'catalan': {
        'respuestaCorrecta': 'Felicitats! Resposta correcta.',
        'respuestaIncorrecta': 'Resposta incorrecta. Fi del joc.',
        'tiempoAgotado': 'Temps esgotat. Fi del joc.',
        'seleccionaRespuesta': 'Si us plau, seleccioneu una resposta.',
        'subirNivel': 'Ara pujarà el nivell de dificultat a ',
        'juegoTerminado': 'Has respost totes les preguntes! Joc acabat.',
        'palabraInapropiada': 'IMPOSSIBLE! El nom conté una paraula inadequada: '
    },
    'english': {
        'respuestaCorrecta': 'Congratulations! Correct answer.',
        'respuestaIncorrecta': 'Incorrect answer. End of the game.',
        'tiempoAgotado': 'Time out. End of the game.',
        'seleccionaRespuesta': 'Please select an answer.',
        'subirNivel': 'Now it will increase the difficulty level to ',
        'juegoTerminado': 'You have answered all the questions! You\'ve finished the game.',
        'palabraInapropiada': 'IMPOSSIBLE! The name contains an inappropriate word: '
    }
};
function showMessage(message) {
    const messageElement = document.getElementById('message');
    messageElement.textContent = message;
    messageElement.style.display = 'block';
    setTimeout(function () {
        hideMessage();
    }, 3000);
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

function stopCountUpChronometer() {
    clearInterval(intervalo);
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
    const currentQuestion = document.querySelector(".pregunta:not(.bloqueada)");
    const timerQuestion = currentQuestion.querySelector('.timerQuestion');
    if (timeLeft > 0) {
        timerQuestion.textContent = timeLeft;
        timeLeft--;
        localStorage.setItem('timeLeft', timeLeft);
        saveSession('timeLeft=' + timeLeft,'game.php');
    } else {
        timerQuestion.textContent = "--:--";
        if (document.getElementById("spanish")) {
            var language = "spanish";
        } else if (document.getElementById("catalan")) {
            var language = "catalan";
        } else if (document.getElementById("english")) {
            var language = "english";
        }
        showMessage(mensajes[language]['tiempoAgotado']);
        clearInterval(intervalCountDown);
        pageLose();
    }
}

function pageLose(){
    let niveles = document.querySelector(".nivel_actual");
    let nivel = niveles.getAttribute("nivelactual");
    stopCountUpChronometer();
    calculateTotalPoints(calculoderespuesta(preguntaActual,nivel));
    playIncorrectSound();
    setTimeout(function () {
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
    }, 3000);
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

function comodinLlamada() {
    stopCountDownChronometerContinue();
    const modal = document.getElementById('popupModal');
    const imagen = document.getElementById('popupImage');
    const imagenSrcPublico = 'imgs/llamada.png';
    const closeButton = document.querySelector('.close-button');
    const audioPopup = new Audio('mp3/ringtone.mp3');
    modal.style.display = "block";
    imagen.src = imagenSrcPublico;
    imagen.classList.add('scale-animation-call');
    const repetitions = Math.floor(Math.random() * 10) + 1;
    const playAudio = (repetitionsLeft) => {
        if (repetitionsLeft > 0) {
            audioPopup.play();
            closeButton.addEventListener('click', function() {
                audioPopup.pause();
                audioPopup.currentTime = 0;
                modal.style.display = "none";
            });
            audioPopup.onended = () => {
                playAudio(repetitionsLeft - 1);
                if (repetitionsLeft === 1) {
                    // Ocultar la imagen al finalizar el untimo sonido
                    imagen.style.display = 'none';
                    //Añadir un atributo sobre numero random
                    const numRepetitions = document.getElementById('tituloLlamada');
                    numRepetitions.setAttribute('Repeticiones', repetitions);
                    // Mostrar el campo del formulario
                    const titelcall = document.getElementById('preguntaLlamada');
                    titelcall.style.display = 'block';

                }
            };
        }
    };
    playAudio(repetitions);
    const botonPublic0 = document.getElementById('buttoncomodinLlamada');
    botonPublic0.setAttribute('disabled', '');
    saveSession('comodinLlamada=' + 'usado','game.php');
}

function comodinCantidadSonido() {
    //El input del mini formulario
    const vecesAudioInput = document.getElementById('vecesAudio');
    const cantidadLlamadaAudio = vecesAudioInput.value;

    //Las veces corectas que se repitio el audio
    const numRepetitions = document.getElementById('tituloLlamada');
    const RepeticionAudioCorrecto = numRepetitions.getAttribute('Repeticiones'); 

    //Respuesta correcta del juego general
    const respuestaDesenfocada = document.querySelector(".respuesta:not(.bloqueada)");
    const respuestaCorrecta = respuestaDesenfocada.getAttribute("data-correcta");

    if (cantidadLlamadaAudio == RepeticionAudioCorrecto) {
        //Obtener texto respuesta corecta
        const respuestaDesenfocadatexto = document.querySelector('div[data-respuesta="'+respuestaCorrecta+'"]');
        const textoRespuestaCorrecta = respuestaDesenfocadatexto.textContent;
        //Ocultamos el formulario
        const titelcall = document.getElementById('preguntaLlamada');
        titelcall.style.display = 'none';
        //Mostramos el div de la respuesta correcta
        const titeQuestion = document.getElementById('respuestaLlamada');
        titeQuestion.style.display = 'block';
        //Imprimimos la respuesta corecta
        const pTexto = document.getElementById("RespuestaTexto");
        pTexto.textContent = textoRespuestaCorrecta;

    } else {
        let respuestaIncorrecta;
        do {
            respuestaIncorrecta = Math.floor(Math.random() * 4);
        } while (respuestaIncorrecta == respuestaCorrecta);
        //Obtener texto respuesta incorrecta
        const respuestaDesenfocadatexto = document.querySelector('div[data-respuesta="'+respuestaIncorrecta+'"]');
        const textoRespuestaCorrecta = respuestaDesenfocadatexto.textContent;
        //Ocultamos el formulario
        const titelcall = document.getElementById('preguntaLlamada');
        titelcall.style.display = 'none';
        //Mostramos el div de la respuesta incorrecta
        const titeQuestion = document.getElementById('respuestaLlamada');
        titeQuestion.style.display = 'block';
        //Imprimimos la respuesta incorrecta
        const pTexto = document.getElementById("RespuestaTexto");
        pTexto.textContent = textoRespuestaCorrecta;
    }

}

function cerrarImagen() {
    startCountDownChronometer();
    const modal = document.getElementById('popupModal');
    modal.style.display = "none";
    const titelcall = document.getElementById('preguntaLlamada');
    titelcall.style.display = 'none';
    const titeQuestion = document.getElementById('respuestaLlamada');
    titeQuestion.style.display = 'none';
    const imagen = document.getElementById('popupImage');
    imagen.removeAttribute('style');
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
            stopCountUpChronometer();
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
            }, 3000);
        }
    } else {
        showMessage(mensajes[language]['seleccionaRespuesta']);
    }
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
                calculateTotalPoints(18);
                stopCountUpChronometer();
                showMessage(mensajes[language]['juegoTerminado']);
                setTimeout(function() {
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
            }, 3000);
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

// FUNCION DE VALIDAR NOMBRE.
function validateName() {
    if (document.getElementById("spanish")) {
        var language = "spanish";
    } else if (document.getElementById("catalan")) {
        var language = "catalan";
    } else if (document.getElementById("english")) {
        var language = "english";
    }
    var nombre = document.getElementById("nombre").value;
    var inappropriateWords = [
        "retrasado","retrasat","retarded",
        "maldito","maleït","fucking",
        "maldita","maleïda","fucking",
        "puta","puta","whore",
        "puto","put","whore",
        "gilipollas","gilipolles","idiot",
        "tonto","tonto","fool",
        "golfo","golf","asshole",
        "pene","penis","penis",
        "vagina","vagina","vagina",
        "polla","polla","dick",
        "coño","cony","pussy",
        "culo","cul","butt",
        "gordo","gord","fat",
        "subnormal","subnormal","abnormal",
        "anormal","anormal","abnormal",
        "mierda","merda","shit",
        "droga","droga","drug",
        "maricon","maricó","faggot",
        "soplagaitas","soplagaites","blowjob",
        "capullo","capull","jerk",
        "pardillo","pardell","gullible",
        "lameculos","llepaculs","ass-licker",
        "pendejo","penso","dumbass",
        "follar","follar","fuck",
        "pajas","pajilles","wank",
        "masturbar","masturbar","masturbate",
        "suicidar","suïcidar","suicide"
    ];
    for (var i = 0; i < inappropriateWords.length; i++) {
        if (nombre.toLowerCase().includes(inappropriateWords[i].toLowerCase())) {
            showMessage(mensajes[language]['palabraInapropiada'] + inappropriateWords[i]);
            return false;
        }
    }
    return true;
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