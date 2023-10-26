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
            respuestaSeleccionada.classList.remove('seleccionada'); // Remove the yellow selection upon a correct answer
            respuestaSeleccionada.classList.add('acertada'); // Change the selection color to green upon a correct answer
            scrollSiguientePregunta(preguntaIndex);
            mostrarSiguientePregunta(preguntaIndex, nivel, language);
        } else {
            // console.log(respuestaElegida);
            // console.log(respuestaCorrecta);
            let puntos=calculoderespuesta(preguntaActual,nivel);
            playIncorrectSound();

            respuestaSeleccionada.classList.remove('seleccionada'); // Remove the yellow selection upon a correct answer
            respuestaSeleccionada.classList.add('fallada'); //And highlight the selection in red.

            // Alert that the response is incorrect
            alert(mensajes[language]['respuestaIncorrecta']);

            // Enable the answer button for the next question
            const btnResponder = document.getElementById('responder-btn-' + preguntaActual);
            btnResponder.setAttribute('disabled', '');

            
            
            // Lock the question
            const bloquearPregunta = document.getElementById('pregunta' + (preguntaActual));
            bloquearPregunta.classList.add('bloqueada');

            // Lock the answers
            for (let bucle = 0; bucle <= 3; bucle++) {

                const bloquearRespuestas = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
                bloquearRespuestas.classList.add('bloqueada');
            }

            // Go to the page 'lose'
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
    window.location.href = 'index.php'; // Redirect to the beginning
}

function nextQuestion(nivel){
    window.location.href = 'game.php?niveles=' + nivel;
}


function mostrarSiguientePregunta(preguntaIndex, nivel, language) {
    preguntaActual2++;

    if (preguntaActual2 >= 3) {
        if (nivel <= 6) {
            // If the user has answered correctly to 3 questions, increase the level
            nivel++;
            console.log(nivel);

            if (nivel <= 6) {

                // Lock the question.
                const bloquearPregunta = document.getElementById('pregunta' + (preguntaActual));
                bloquearPregunta.classList.add('bloqueada');

                // Lock the answers
                for (let bucle = 0; bucle <= 3; bucle++) {

                    const bloquearRespuestas = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
                    bloquearRespuestas.classList.add('bloqueada');
                }

                // Alert to go to the next level.
                alert(mensajes[language]['subirNivel'] + nivel + '.');



                // Insert the button to go to the next page of questions
                const next = document.getElementById("next-question");
                next.style.display = "";
                //document.body.innerHTML += "<button id='next-question' onclick='nextQuestion("+nivel+")' ' >Siguiente pregunta</button>";
            } else {
                // The user has completed all the levels
                // Display a game completion message or redirect to the main page
                alert(mensajes[language]['juegoTerminado']);
                window.location.href = 'win.php?puntage=18'; // Redirigir a la página win.php
            }
        }
    }


    // Enable the answer button for the next question
    const btnResponder = document.getElementById('responder-btn-' + preguntaActual);
    btnResponder.setAttribute('disabled', '');

    // Lock the question
    const bloquearPregunta = document.getElementById('pregunta' + (preguntaActual));
    bloquearPregunta.classList.add('bloqueada');

    // Lock the answers.
    for (let bucle = 0; bucle <= 3; bucle++) {

        const bloquearRespuestas = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
        bloquearRespuestas.classList.add('bloqueada');
    }

    // Blur the next question
    const desenfoqueSiguientePregunta = document.getElementById('pregunta' + (preguntaActual + 1));
    desenfoqueSiguientePregunta.classList.remove('bloqueada');

    preguntaActual++;
    preguntaIndex++;

    // Blur the next answers
    for (let bucle = 0; bucle <= 3; bucle++) {

        const desenfoqueSeguientesRespuestas = document.getElementById('respuesta-' + preguntaIndex + '-' + bucle);
        console.log(desenfoqueSeguientesRespuestas);
        desenfoqueSeguientesRespuestas.classList.remove('bloqueada');
    }



}

// Function to play the correct sound
function playCorrectSound() {
    var correctSound = document.getElementById("correctSound");
    correctSound.play();
}
// Function to play the incorrect sound.
function playIncorrectSound() {
    var incorrectSound = document.getElementById("incorrectSound");
    incorrectSound.play();
}
