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

function mostrarComodines() {
    var comodinesDiv = document.getElementById("comodines");
    var mostrarComodinesButton = document.getElementById("mostrarComodinesButton");
    var comodinesBotones = document.querySelector(".comodinesBotones");

    if (comodinesDiv.style.display === "none") {
        comodinesDiv.style.display = "block";
        mostrarComodinesButton.textContent = "x";
        comodinesBotones.classList.add("expandido");
    } else {
        comodinesDiv.style.display = "none";
        mostrarComodinesButton.textContent = "C";
        comodinesBotones.classList.remove("expandido");
    }}    
    
// ————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
// CÓDIGOS DE INDEX.PHP
// ————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
function showMessage(message) {
    const messageElement = document.getElementById('message');
    messageElement.textContent = message;
    messageElement.style.display = 'block';
    setTimeout(function () { hideMessage(); }, 4000);
}

function hideMessage() {
    const messageElement = document.getElementById('message');
    messageElement.style.display = 'none';
}

// ————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
// CÓDIGOS DE "GAME.PHP"
// ————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
/* CRONÓMETRO COMÚN: Aquí lo que hacemos es */
function startCountUpChronometer() {
    time++;
    const minutes = Math.floor(time / 60);
    const seconds = time % 60;
    const minutes00 = minutes < 10 ? "0" + minutes : minutes;
    const second00 = seconds < 10 ? "0" + seconds : seconds;
    document.getElementById("timer").textContent = minutes00  + ":" + second00;
    let tiempo = minutes00  + ":" + second00;
    localStorage.setItem("time", time);
    saveSession('time=' + tiempo, 'game.php');
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
    const currentQuestion = document.querySelector(".pregunta:not(.bloqueada)");
    const timerQuestion = currentQuestion.querySelector('.timerQuestion');
    if (timeLeft > 0) {
        timerQuestion.textContent = timeLeft;
        timeLeft--;
        localStorage.setItem('timeLeft', timeLeft);
        saveSession('timeLeft=' + timeLeft, 'game.php');
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

/* CRONÓMETRO REGRESIVO: Aquí lo que hacemos es */
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

// COMODINES ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
/* COMODÍN 50%: Aquí lo que hacemos es */
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
    saveSession('comodin50=' + 'usado', 'game.php');
}

/* COMODÍN DE TIEMPO EXTRA: Aquí lo que hacemos es */
function buttonTime() {
    const buttonTime = document.getElementById('buttonComodinTime');
    buttonTime.setAttribute('disabled', '');
    saveSession('comodinTime=' + 'usado', 'game.php');
    timeLeft += 30;
    const timerQuestion = document.querySelector('.timerQuestion');
    timerQuestion.textContent = timeLeft;
    clearInterval(intervalCountDown);
    intervalCountDown = setInterval(updateCountDownChronometer, 1000);
};

/* COMODÍN DEL PÚBLICO: Aquí lo que hacemos es */
function comodinPublico() {
    stopCountDownChronometerContinue();
    const answerEnabled = document.querySelector(".respuesta:not(.bloqueada)");
    const answerCorrect = answerEnabled.getAttribute("data-correcta");
    const answersEnabled = document.querySelectorAll(".respuesta:not(.bloqueada)");
    const answerTotal = [];
    let responseCorrect = null;
    let responseIncorrect = null;
    for (let i = 0; i < answersEnabled.length; i++) {
        const answer = answersEnabled[i];
        answerTotal[i] = answer.textContent;
        if (answer.getAttribute("data-respuesta") === answerCorrect) {
            responseCorrect = answer.getAttribute("data-respuesta");
        } else{
            responseIncorrect = answer.getAttribute("data-respuesta");
        }
    }
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
            if (answerTotal.length === 4) {
                if (probabilidad <= 0.8) {
                    segundaImagen.src = 'graficoBarras/' + answerCorrect + '.png';
                } else {
                    segundaImagen.src = 'graficoBarras/' + responseIncorrect + '.png';
                }
            } else if (answerTotal.length === 2) {
                if (probabilidad <= 0.8) {
                    segundaImagen.src = 'graficoBarras/' + answerCorrect + responseIncorrect + '.png';
                } else {
                    segundaImagen.src = 'graficoBarras/' + responseIncorrect + answerCorrect + '.png';
                }
            }
        }, 1000);
    }, 6000)

    const botonPublic0 = document.getElementById('boton-publico');
    botonPublic0.setAttribute('disabled', '');
    saveSession('comodinPublico=' + 'usado', 'game.php');
}

/* COMODÍN DE LA LLAMADA: Lo que hacemos aquí es, primero e importante, PARAR el contador.
Ahora que el contador está parado, obtenemos las ID de los "div" del "Pop Up" que hemos creado, y ponemos la imagen que se mostrará. Después de esto hemos añadido una "X" para que el
jugador cierre la ventana —si él quiere—. Por si el jugador le da al "botón" de cerrar, paramos el archivo ".mp3", por si acaso. Ahora que hemos configurado esto, preparamos el audio
de la llamada y aplicamos la animación pedida por el "Product Owner" a la imagen con la línea "imagen.classList.add("scale-animation-call")".
Ahora viene el desarrollo del juego: generamos un número al azar entre 1 y 10, y después de esta configuración, crearemos una función para reproducir el archivo ".mp3" con el tono de
llamada que se repetirá aleatoriamente. Cuando el audio termine,
Obtenemos la referencia del botón del comodín de la llamada y lo deshabilitamos cuando se haya usado. Finalmente, ¡guardamos el uso del comodín! :) */
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
                    imagen.style.display = 'none';
                    const numRepetitions = document.getElementById('tituloLlamada');
                    numRepetitions.setAttribute('Repeticiones', repetitions);
                    const titelcall = document.getElementById('preguntaLlamada');
                    titelcall.style.display = 'block';

                }};
        }};
    playAudio(repetitions);
    const botonPublic0 = document.getElementById('buttoncomodinLlamada');
    botonPublic0.setAttribute('disabled', '');
    saveSession('comodinLlamada=' + 'usado','game.php');
}

// COMODÍN DE LA LLAMADA: II ———————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
/* Aquí creamos una función donde comprobamos si el jugador ha acertado la cantidad de veces que ha sonado el teléfono. Primero, obtenemos el texto de la respuesta correcta para
mostrarla al final, ocultamos el formulario y mostramos el "div" con la respuesta correcta. :) Pero, ¿qué pasa si el jugador no acierta? Pues, con un "else", construimos el código para
obtener la respuesta introducida por el usuario y ocultamos el formulario, para después mostrar el "div" de la respuesta incorrecta. */

function comodinCantidadSonido() {
    const audioPopupFail = new Audio('mp3/fallCall.mp3');
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
        const respuestaDesenfocadatexto = document.querySelector('div[data-respuesta="' + respuestaCorrecta + '"]:not(.bloqueada)');
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
        //Ocultamos el formulario
        const titelcall = document.getElementById('preguntaLlamada');
        titelcall.style.display = 'none';
        //Mostramos el div de la respuesta incorrecta
        const titeQuestion = document.getElementById('respuestaLlamada');
        titeQuestion.style.display = 'block';
        //Mostramos el div de la respuesta incorrecta
        const validQuestion = document.getElementById('respuestaValida');
        validQuestion.style.display = 'none';
        const invalidQuestion = document.getElementById('respuestaInvalida');
        invalidQuestion.style.display = 'block';
        audioPopupFail.play();
                
    }

}

// FUNCIONES PARA CERRAR LOS "POP UPS" —————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
const loginPopUp = document.getElementById("loginPopUp");

function togglePopUp() {
    if (loginPopUp.style.display === "none" || loginPopUp.style.display === "") {
        loginPopUp.style.display = "block";
    } else { loginPopUp.style.display = "none"; }}

const loginButton = document.getElementById("loginButton");
const popupContainer = document.getElementById("loginPopUp");
const closeButton = document.getElementById("closeButton");

function showPopup() { popupContainer.style.display = "block"; }
function closePopup() { popupContainer.style.display = "none"; }

loginButton.addEventListener("click", showPopup);
closeButton.addEventListener("click", closePopup);

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

// CÓDIGOS DE "GAME.PHP" ———————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
/* Verificamos si la respuesta existe y no está bloqueada. Si no está bloqueada, la seleccionamos y quitamos la clase bloqueada Seguidamente, obtenemos una lista con todas las
respuestas para la pregunta y recorremos por todas ellas para deseleccionarlas y luego añadimos la clase "seleccionada" a la respuesta actual, para indicar visualmente al jugador qué
respuesta está escogiendo. Finalmente, después de seleccionarla, ¡habilitamos el botón de respuesta! :)*/
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
    }}

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

/* SCROLL DE PREGUNTAS: Aquí simplemente implementamos el "Scroll" cuando el jugador responde a la pregunta, para hacer la experiencia más cómoda. */
function scrollSiguientePregunta(preguntaIndex) {
    const preguntaId = 'pregunta' + preguntaIndex;
    const preguntaElement = document.getElementById(preguntaId);
    if (preguntaElement) {
        preguntaElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }}

/* RESPONDER PREGUNTA: Aquí */
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


/* REGRESAR: Aquí simplemente redireccionamos al inicio. */
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
                stopCountDownChronometerContinue();
                showMessage(mensajes[language]['juegoTerminado']);
                setTimeout(function () {
                    const form = document.createElement('form');
                    const input = document.createElement('input');
                    form.method = 'POST';
                    form.action = 'win.php';
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
        desenfoqueSeguientesRespuestas.classList.remove('bloqueada');
    }}

/* CALCULAR LOS PUNTOS TOTALES: Creamos una función donde obtendremos el tiempo guardado en el almacenamiento local del navegador. Si no hay tiempo pondremos que el total de puntos
obtenido del tiempo es 0. Después, calculamos los puntos relacionados con el tiempo si se encuentra en el rango establecido, si no, es 0.
Calculamos los puntos por respuestas correctas si la cantidad está en un rango específico (1 a 18 respuestas). También calculamos los puntos total sumando los puntos por tiempo y los
puntos por respuestas correctas... Si no hay respuestas correctas, el puntaje total es 0. Finalmente, ¡lo guardamos en la sesión del navegador! :)*/
function calculateTotalPoints(correctAnswer) {
    const tiempo = parseInt(localStorage.getItem("time")) || 0;
    let pointsTime = 0;
    if (tiempo >= 1 && tiempo <= 1200) {
        pointsTime = 1200 - tiempo + 1;
    } else{ pointsTime = 0; }
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


// ARCHIVOS ".MP3" ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
/* Aquí solo configuramos los archivos ".mp3" para que suenen en determinados momentos. */
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

// FUNCIONES DE "PUBLISH".
function publishGame2(){
    const mostrarFormulartio = document.getElementById("guardarpartida");
    mostrarFormulartio.style.display = "";
    saveSession('buttonPublish=' + 'usado','win.php');
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



// CAMBIO DE IDIOMA ————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
function changeLanguage(language) {
    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        }, body: 'language=' + language, })
    .then(response => response.text())
    .then(data => {
        window.location.reload();
    });
}

function saveSession(id,page) {
    fetch(page, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        }, body: id, })
    .then(response => response.text())
    .then(data => {
        //console.log(data);
    });
};

/* "LOG IN": La función "login()" se activa cuando el usuario envía el formulario. Primero, recopilamos los valores ingresados por el usuario en los campos de nombre de usuario y
contraseña, a continuación, obtenemos una referencia al elemento HTML que se utilizará para mostrar mensajes de error al usuario si es necesario.
Después, definimos dos variables: "admin_username" y "admin_password", que almacenan las credenciales de administrador esperadas. La función compara los valores ingresados por el
usuario con las credenciales de administrador utilizando una declaración "if". :) Si las credenciales ingresadas por el usuario coinciden con las credenciales de administrador, la
función redirige al usuario a la página "create.php". Esto indica que el usuario ha iniciado sesión correctamente. Si no coinciden, la función muestra un mensaje de error al usuario
utilizando el elemento HTML de referencia. La función devuelve false para evitar que el formulario se envíe si las credenciales son incorrectas. Esto evita que la página se recargue. */

function login() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    var errorMessage1 = document.getElementById("error-message1");
    var errorMessage2 = document.getElementById("error-message2");
    var errorMessage3 = document.getElementById("error-message3");
    var errorMessage4 = document.getElementById("error-message4");
    var errorMessage5 = document.getElementById("error-message5");

    if (!username || !password) {
        errorMessage2.style.display= "none";
        errorMessage3.style.display= "none";
        errorMessage4.style.display= "none";
        errorMessage5.style.display= "none";

        errorMessage1.style.color = "green";
        errorMessage1.style.display= "block";

        return;
    }
    fetch('./configuracio-admin.txt')
        .then(function(response) {
            if (!response.ok) {
                throw new Error('No se pudo cargar el archivo de configuración');
            }
            return response.text();
        })
        .then(function(data) {
            var lines = data.split('\n');
            
            if (lines.length >= 2) {
                var adminUsername = lines[0].trim();
                var adminPassword = lines[1].trim();
                
                if (username === adminUsername && password === adminPassword) {
                    errorMessage2.style.display= "none";
                    errorMessage1.style.display= "none";
                    errorMessage4.style.display= "none";
                    errorMessage5.style.display= "none";

                    errorMessage3.style.color = "green"; 
                    errorMessage3.style.display= "block";
                    setTimeout(function() {
                        window.location.href = "create.php";
                    }, 2000);
                } else {
                    errorMessage2.style.display= "none";
                    errorMessage3.style.display= "none";
                    errorMessage1.style.display= "none";
                    errorMessage5.style.display= "none";

                    errorMessage4.style.color = "red";
                    errorMessage4.style.display= "block";
                }
            } else {
                errorMessage2.style.display= "none";
                errorMessage3.style.display= "none";
                errorMessage4.style.display= "none";
                errorMessage1.style.display= "none";

                errorMessage5.style.color = "red";
                errorMessage5.style.display= "block";
            }
        })
        .catch(function(error) {
            errorMessage1.style.display= "none";
            errorMessage3.style.display= "none";
            errorMessage4.style.display= "none";
            errorMessage5.style.display= "none";

            errorMessage2.style.color = "red";
            errorMessage2.style.display= "block";
        });
}