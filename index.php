<?php
    session_start();
    $_SESSION['language'] = isset($_SESSION['language']) ? $_SESSION['language'] : 'spanish';
    isset($_POST['language']) ? $_SESSION['language'] = $_POST['language'] : null;
    $selectedLanguage = $_SESSION['language'];
    $hideStyle = 'style="display: none;"';
    $showStyle = 'style="display: block;"';
    $_SESSION['comodin50'] = 'nousado';
    $_SESSION['comodinTime'] = 'nousado';
    $_SESSION['comodinPublico'] = 'nousado';
    $_SESSION['buttonPublish'] = 'nousado';
    $_SESSION['comodinLlamada'] = 'nousado';
    unset($_SESSION['nivels']);
    unset($_SESSION['answer']);
?>

<!DOCTYPE html>
<html lang="es">
<html>
    <head>
        <title>¿Quién quiere ser millonario?</title>
        <noscript>
            Esta página requiere tener Javascript activado. Por favor, actívalo  para poder jugar.
            <style>div { background-color: white; display: none; bottom: 0; }</style>
        </noscript>
        <meta author="" content="Claudia, Mehdi i Marcelo (2n DAW)">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="style.css" rel="stylesheet">
        <link rel="shortcut icon" href="imgs/logo.png" />
    </head>
    
    <body class="indexPage">
        <!-- ESPAÑOL -->    
        <div id="spanish" <?php echo ($selectedLanguage != 'spanish') ? $hideStyle : $showStyle; ?>>
            <header>
                <?php
                    if ($_SESSION['language'] === 'spanish') {
                        echo "<a href='/index.php'><h1>¿Quién quiere ser millonario?</h1></a>";
                        echo "<button onclick='login()' id='loginButton'>Inicia sesión</button>";
                    }
                ?>
            </header>
            <div class="container">                
                <h2><strong>Bienvenido</strong></h2>
                <h3><em>Instrucciones del juego</em></h3>
            
                <p>El juego en línea de <em>¿Quién quiere ser millonario?</em> funciona tal como el exitoso programa de la vida real.
            
                <br /><br />Antes de empezar, hay que comprender que el juego en línea contiene un total de seis dificultades, cada una repartidas en tres preguntas, por
                lo consecuente hay 18 preguntas en total. Las dificultades son: muy fácil, fácil, medio, versado, difícil y muy difícil.
                El juego comienza con una pregunta del primer nivel de dificultad. Si respondes correctamente, se mostrará la siguiente pregunta, y
                así hasta la tercera. Si pasas la primera ronda, se aumentará la dificultad. El juego SIEMPRE cambia la dificultad automáticamente después de
                que el usuario responda la tercera pregunta de la tanda.<br/><br /></p>
                
                <h3><em>¿Cómo empezar a jugar?</em></hr>
                
                <p>Primero, tienes la opción de escoger el idioma en el que quieres que se muestre toda la página debajo de esta explicación. Cuando lo hayas escogido,
                debes clicar en el botón <em>Jugar</em> —se situa debajo de esta explicación— para poder iniciar tu partida. No se creará un usuario al menos que
                especifiques que sí quieres y que das el consentimiento a subir tu nombre de usuario, junto a tu ID de jugador y los puntos que has sacado para publicarlo
                en la tabla de clasificaciones que se muestra al clicar en el botón <em>Hall of fame</em> o cuando acaba la partida (tanto si has ganado como si has perdido).
            
                <br /><br />Lo primero que verás es una página nueva con la primera pregunta. Deberás clicar a la respuesta que creas correcta y la página te 
                mostrará si has acertado o si te has equivocado.</p>

                <ul>
                    <li>Si te has equivocado, ¡no te preocupes!, la página te mostrará un botón para volver al inicio y puedes volver a jugar siempre que quieras.</li>
                    <li>Si has acertado, ¡enhorabuena!, aparecerá en la página la siguiente pregunta. Y así hasta completar las seis dificultades.</li>
                </ul>

                <p>Si has ganado, ¡se mostrará una nueva pantalla donde se te felicitará por tu gran hazaña y se mostrará la cantidad de dinero que has ganado! También
                    saldrá la tabla de clasificaciones. Antes de esto te preguntaremos si quieres publicar tus datos antes mencionados (nombre de usuario, ID de usuario
                    y puntuación). Jamás publicaremos tus datos sin consentimiento.</p>
                
                    <div class="ghof-buttons">
                        <a class="play-button" href="game.php"><em>Jugar</em></button>
                        <a class="halloffame-button" href="ranking.php"><em>Hall of fame</em></a>
                    </div>
                <div class="languagesimages">
                    <a class="no-underline" href="#">
                        <img src="imgs/españa.jpeg" alt="Imagen de la bandera de España" onclick="changeLanguage('spanish')">
                    </a>
                    <a class="no-underline" href="#">
                        <img src="imgs/catalunya.jpeg" alt="Imagen de la bandera de Catalunya" onclick="changeLanguage('catalan')">
                    </a>
                    <a class="no-underline" href="#">
                        <img src="imgs/uk.webp" alt="Imagen de la bandera del Reino Unido" onclick="changeLanguage('english')">
                    </a>
                </div>

                <div class="presentationimage">
                    <img src="imgs/netflix-millonariopng.jpg" alt="Escena del juego '¿Quién quiere ser millonario' Sale el presentador y un jugador.">
                </div>
            </div>
        </div>

        <!-- CATALÀ -->
        <div id="catalan" <?php echo ($selectedLanguage != 'catalan') ? $hideStyle : $showStyle; ?>>
            <header>
                <?php
                    if ($_SESSION['language'] === 'catalan') {
                        echo "<a href='/index.php'><h1>Qui vol ser millonari?</h1></a>";
                        echo "<button onclick='login()' id='loginButton'>Inicia sessió</button>";
                    }
                ?>
            </header>

            <div class="container">    
                <h2><strong>Benvingut</strong></h2>
                <h3><em>Instruccions del joc</em></h3>
                
                <p>El joc en línia de <em>Qui vol ser milionari?</em> funciona com el programa d'èxit de la vida real.
                
                <br /><br />Abans de començar, cal comprendre que el joc en línia conté un total de sis dificultats, cadascuna repartida en tres preguntes, per
                tant hi ha 18 preguntes en total. Les dificultats són: molt fàcil, fàcil, mitjà, versat, difícil i molt difícil.
                El joc comença amb una pregunta del primer nivell de dificultat. Si respones correctament, es mostrarà la següent pregunta, i
                així fins a la tercera. Si superes la primera ronda, la dificultat augmentarà. El joc SEMPRE canvia la dificultat automàticament després de
                que l'usuari respongui a la tercera pregunta del conjunt.<br/><br /></p>
                
                <h3><em>Com començar a jugar?</em></h3></hr>
                
                <p>Primer, tens l'opció de triar l'idioma en què vols que es mostri tota la pàgina sota aquesta explicació. Quan hagis triat,
                has de fer clic al botó <em>Jugar</em> – es situa sota aquesta explicació – per iniciar la teva partida. No es crearà un usuari llevat que
                especifiquis que sí ho vols i que dónes el consentiment per penjar el teu nom d'usuari, juntament amb el teu ID de jugador i els punts que has aconseguit, per publicar-ho
                a la taula de classificació que es mostra en fer clic al botó <em>Hall of Fame</em> o quan acabi la partida (tant si has guanyat com si has perdut).
                
                <br /><br />El primer que veuràs és una pàgina nova amb la primera pregunta. Hauràs de fer clic a la resposta que creguis correcta i la pàgina et
                mostrarà si has encertat o t'has equivocat.</p>

                <ul>
                    <li>Si t'has equivocat, no et preocupis, la pàgina et mostrarà un botó per tornar a l'inici i pots tornar a jugar sempre que vulguis.</li>
                    <li>Si has encertat, enhorabona, apareixerà a la pàgina la següent pregunta. I així fins a completar les sis dificultats.</li>
                </ul>

                <p>Si has guanyat, es mostrarà una nova pantalla on se't felicitarà per la teva gran gesta i es mostrarà la quantitat de diners que has guanyat! També
                    sortirà la taula de classificació. Abans d'això et preguntarem si vols publicar les teves dades abans esmentades (nom d'usuari, ID d'usuari
                    i puntuació). Mai no publicarem les teves dades sense el teu consentiment.</p>
                
                <div class="ghof-buttons">
                    <a class="play-button" href="game.php"><em>Jugar</em></button>
                    <a class="halloffame-button" href="ranking.php"><em>Hall of fame</em></a>
                </div>
                <div class="languagesimages">
                    <a class="no-underline" href="#">
                        <img src="imgs/españa.jpeg" alt="Imagen de la bandera de España" onclick="changeLanguage('spanish')">
                    </a>
                    <a class="no-underline" href="#">
                        <img src="imgs/catalunya.jpeg" alt="Imagen de la bandera de Catalunya" onclick="changeLanguage('catalan')">
                    </a>
                    <a class="no-underline" href="#">
                        <img src="imgs/uk.webp" alt="Imagen de la bandera del Reino Unido" onclick="changeLanguage('english')">
                    </a>
                </div>

                <div class="presentationimage">
                    <img src="imgs/netflix-millonariopng.jpg" alt="Escena del juego '¿Quién quiere ser millonario' Sale el presentador y un jugador.">
                </div>
            </div>
        </div>

        <!-- ENGLISH -->
        <div id="english" <?php echo ($selectedLanguage != 'english') ? $hideStyle : $showStyle; ?>>
            <header>
                <?php
                    if ($_SESSION['language'] === 'english') {
                        echo "<a href='/index.php'><h1>Who wants to be a millionaire?</h1></a>";
                        echo "<button onclick='login()' id='loginButton'>Log in</button>";
                    }
                ?>
            </header>

            <div class="container">
                <h2><strong>Welcome</strong></h2>
                <h3><em>Game instructions</em></h3>

                <p>The online game of <em>Who Wants to Be a Millionaire?</em> works just like the successful real-life TV show.

                <br /><br />Before you start, it's important to understand that the online game has a total of six difficulties, each one distributed into three questions, so
                there are 18 questions in total. The difficulties are: very easy, easy, medium, expert, hard, and very hard.
                The game starts with a question from the first level of difficulty. If you answer correctly, the next question will be displayed, and
                so on until the third question. If you pass the first round, the difficulty will increase. The game ALWAYS changes the difficulty automatically after
                the user answers the third question in the set.<br/><br /></p>

                <h3><em>How to start playing?</em></hr>

                <p>First, you have the option to choose the language in which you want the entire page to be displayed below this explanation. Once you have chosen,
                you have to click the <em>Play</em> button –located below this explanation– to start your game. A user will not be created unless you
                specify that you want one and give consent to upload your username, along with your player ID and the points you have scored, to publish it
                on the leaderboard that is displayed when you click the <em>Hall of Fame</em> button or when the game ends (whether you win or lose).

                <br /><br />The first thing you will see is a new page with the first question. You will need to click on the answer you believe is correct, and the page will
                show you whether you got it right or wrong.</p>

                <ul>
                    <li>If you get it wrong, don't worry!, the page will show you a button to return to the beginning, and you can play again whenever you want.</li>
                    <li>If you get it right, congratulations!, the next question will appear on the page. And so on until you complete all six difficulties.</li>
                </ul>

                <p>If you win, a new screen will appear congratulating you on your great achievement and showing the amount of money you have won! The leaderboard will also appear. Before this, we will ask you if you want to publish your aforementioned data (username, user ID,
                and score). We will never publish your data without consent.</p>

                <div class="ghof-buttons">
                    <a class="play-button" href="game.php"><em>Play</em></button>
                    <a class="halloffame-button" href="ranking.php"><em>Hall of fame</em></a>
                </div>
                <div class="languagesimages">
                    <a class="no-underline" href="#">
                        <img src="imgs/españa.jpeg" alt="Imagen de la bandera de España" onclick="changeLanguage('spanish')">
                    </a>
                    <a class="no-underline" href="#">
                        <img src="imgs/catalunya.jpeg" alt="Imagen de la bandera de Catalunya" onclick="changeLanguage('catalan')">
                    </a>
                    <a class="no-underline" href="#">
                        <img src="imgs/uk.webp" alt="Imagen de la bandera del Reino Unido" onclick="changeLanguage('english')">
                    </a>
                </div>

                <div class="presentationimage">
                    <img src="imgs/netflix-millonariopng.jpg" alt="Escena del juego '¿Quién quiere ser millonario' Sale el presentador y un jugador.">
                </div>
            </div>
        </div>
        <?php
            if ($_SESSION['language'] === 'spanish') {
                echo '<div id="loginPopUp" class="loginPopUp">';
                echo '    <div class="contenidoPopUp">';
                echo '        <button class="close-button" id="closeButton" onclick="togglePopUp()">X</button>';
                echo '        <h2>Inicia sesión</h2>';
                
                echo '        <p id="error-message1" style="display: none;">Por favor, ingresa un usuario y una contraseña.</p>';
                echo '        <p id="error-message2" style="display: none;">Error al cargar el archivo de configuración.</p>';
                echo '        <p id="error-message3" style="display: none;">¡Contraseña correcta! Iniciando...</p>';
                echo '        <p id="error-message4" style="display: none;">Credenciales incorrectas. Inténtalo de nuevo.</p>';
                echo '        <p id="error-message5" style="display: none;">Error en el archivo de configuración.</p>';

                echo '        <form>';
                echo '            <label for="username">Usuario</label><br />';
                echo '            <input type="text" name="username" id="username" required><br><br>';
                echo '            <label for="password">Contraseña</label><br />';
                echo '            <input type="password" name="password" id="password" required><br><br>';
                echo '            <button type="button" onclick="login()" id="botonSiguiente">Siguiente</button>';
                echo '        </form>';
                echo '    </div>';
                echo '</div>';
            } elseif ($_SESSION['language'] === 'catalan') {
                echo '<div id="loginPopUp" class="loginPopUp">';
                echo '    <div class="contenidoPopUp">';
                echo '        <button class="close-button" id="closeButton" onclick="togglePopUp()">X</button>';
                echo '        <h2>Inicia sessió</h2>';

                echo '        <p id="error-message1" style="display: none;">Si us plau, introduïu un usuari i una contrasenya.</p>';
                echo '        <p id="error-message2" style="display: none;">Error en carregar el fitxer de configuració.</p>';
                echo '        <p id="error-message3" style="display: none;">Contrasenya correcta! Iniciant...</p>';
                echo '        <p id="error-message4" style="display: none;">Credencials incorrectes. Torneu-ho a provar.</p>';
                echo '        <p id="error-message5" style="display: none;">Error al fitxer de configuració.</p>';

                echo '        <form>';
                echo '            <label for="username">Usuari</label><br />';
                echo '            <input type="text" name="username" id="username" required><br><br>';
                echo '            <label for="password">Contrasenya</label><br />';
                echo '            <input type="password" name="password" id="password" required><br><br>';
                echo '            <button type="button" onclick="login()" id="botonSiguiente">Següent</button>';
                echo '        </form>';
                echo '    </div>';
                echo '</div>';
            } elseif ($_SESSION['language'] === 'english') {
                echo '<div id="loginPopUp" class="loginPopUp">';
                echo '    <div class="contenidoPopUp">';
                echo '        <button class="close-button" id="closeButton" onclick="togglePopUp()">X</button>';
                echo '        <h2>Sign in</h2>';

                echo '        <p id="error-message1" style="display: none;">Please enter a username and password.</p>';
                echo '        <p id="error-message2" style="display: none;">Error loading configuration file.</p>';
                echo '        <p id="error-message3" style="display: none;">Password correct! Starting...</p>';
                echo '        <p id="error-message4" style="display: none;">Incorrect credentials. Try again.</p>';
                echo '        <p id="error-message5" style="display: none;">Configuration file error.</p>';

                echo '        <form>';
                echo '            <label for="username">User</label><br />';
                echo '            <input type="text" name="username" id="username" required><br><br>';
                echo '            <label for="password">Password</label><br />';
                echo '            <input type="password" name="password" id="password" required><br><br>';
                echo '            <button type="button" onclick="login()" id="botonSiguiente">Next</button>';
                echo '        </form>';
                echo '    </div>';
                echo '</div>';
            }
        ?>
        <audio id="start" autoplay>
            <source src="mp3/inicio.mp3" type="audio/mpeg">
        </audio>
        
    <div id="mosca" class="mosca"></div>

    <script src="easteregg.js"></script>
        <!-- FOOTER -->
        <footer class="footerinfo">
            <p>© MCM S.A.</p>
            <p><a href="gmail.com">Contact us</a></p>
            <p><a href="instagra.com">Follow us</a></p>
        </footer>

        <script src="funcionGame.js"></script>
    
    </body>
</html>