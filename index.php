<!DOCTYPE html>
<html>
<head>
    <title>¿Quién quiere ser millonario?</title>
    <link href="style.css" rel="stylesheet">
    <link rel="shortcut icon" href="imgs/logo.png" />
    <script>
        function changeLanguage(language) {
            // Ocultar todos los idiomas
            document.getElementById('spanish').style.display = 'none';
            document.getElementById('catalan').style.display = 'none';
            document.getElementById('english').style.display = 'none';

            // Mostrar el idioma seleccionado
            document.getElementById(language).style.display = 'block';
        }
        <?php
        session_start();
        session_unset();
        ?>
    </script>
</head>
<body class="fondo">
    <div id="spanish">
    <header>
        <h1>¿Quién quiere ser millonario?</h1>
    </header>

    <div class="container">    
        <h2>Bienvenido</h2>
        <h3><em>Instrucciones del juego</em></h3>
        
        <ul>
            <li>Debes responder correctamente una serie de preguntas para ganar dinero.</li>
            <li>Cuanto más niveles pases, se complicarán las preguntas.</li>
        </ul>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In hac habitasse platea dictumst vestibulum rhoncus est. Id donec ultrices tincidunt arcu non. Elementum pulvinar etiam non quam lacus suspendisse faucibus. Pharetra vel turpis nunc eget lorem dolor sed. Aliquet nibh praesent tristique magna sit amet. In cursus turpis massa tincidunt dui ut ornare lectus sit. Quis hendrerit dolor magna eget est lorem ipsum. Facilisis gravida neque convallis a cras semper auctor neque. Fermentum dui faucibus in ornare quam viverra. Vitae elementum curabitur vitae nunc sed. Aliquet nibh praesent tristique magna sit amet purus. Id leo in vitae turpis massa sed elementum. Aliquam eleifend mi in nulla posuere sollicitudin aliquam ultrices. Amet venenatis urna cursus eget nunc scelerisque viverra mauris. A diam maecenas sed enim ut sem viverra aliquet. Pellentesque id nibh tortor id. Mattis rhoncus urna neque viverra justo. Auctor urna nunc id cursus metus aliquam. Rhoncus mattis rhoncus urna neque. Et odio pellentesque diam volutpat. Nec ultrices dui sapien eget mi proin sed libero enim. Eget nunc scelerisque viverra mauris in aliquam sem fringilla. Non consectetur a erat nam at lectus urna. Eu augue ut lectus arcu bibendum at varius vel pharetra.</p>

        <form action="game.php" method="post">
            <input type="hidden" name="language" value="spanish">
            <button class="play-button" type="submit">Jugar</button>
        </form>
        <a class="halloffame-button" href="game.php">Hall of fame</a>
    </div>
    </div>
    <div id="catalan" style="display: none;">
    <header>
        <h1>Quí vol ser millonari?</h1>
    </header>

    <div class="container">    
    <h2>Benvingut</h2>
            <h3><em>Instruccions del joc</em></h3>
            
            <ul>
                <li>Has de respondre correctament una sèrie de preguntes per guanyar diners.</li>
                <li>Com més nivells superis, les preguntes es complicaran.</li>
            </ul>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In hac habitasse platea dictumst vestibulum rhoncus est. Id donec ultrices tincidunt arcu non. Elementum pulvinar etiam non quam lacus suspendisse faucibus. Pharetra vel turpis nunc eget lorem dolor sed. Aliquet nibh praesent tristique magna sit amet. In cursus turpis massa tincidunt dui ut ornare lectus sit. Quis hendrerit dolor magna eget est lorem ipsum. Facilisis gravida neque convallis a cras semper auctor neque. Fermentum dui faucibus in ornare quam viverra. Vitae elementum curabitur vitae nunc sed. Aliquet nibh praesent tristique magna sit amet purus. Id leo in vitae turpis massa sed elementum. Aliquam eleifend mi in nulla posuere sollicitudin aliquam ultrices. Amet venenatis urna cursus eget nunc scelerisque viverra mauris. A diam maecenas sed enim ut sem viverra aliquet. Pellentesque id nibh tortor id. Mattis rhoncus urna neque viverra justo. Auctor urna nunc id cursus metus aliquam. Rhoncus mattis rhoncus urna neque. Et odio pellentesque diam volutpat. Nec ultrices dui sapien eget mi proin sed libero enim. Eget nunc scelerisque viverra mauris in aliquam sem fringilla. Non consectetur a erat nam at lectus urna. Eu augue ut lectus arcu bibendum at varius vel pharetra.</p>

            <form action="game.php" method="post">
            <input type="hidden" name="language" value="catalan">
            <button class="play-button" type="submit">Jugar</button>
        </form>
        <a class="halloffame-button" href="game.php">Hall of fame</a>
    </div>
    </div>
    <div id="english" style="display: none;">
    <header>
        <h1>Who Wants to Be a Millionaire?</h1>
    </header>

    <div class="container">    
        <h2>Welcome</h2>
        <h3><em>Game Instructions</em></h3>
        
        <ul>
            <li>You must answer a series of questions correctly to win money.</li>
            <li>The more levels you pass, the questions will become more difficult.</li>
        </ul>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In hac habitasse platea dictumst vestibulum rhoncus est. Id donec ultrices tincidunt arcu non. Elementum pulvinar etiam non quam lacus suspendisse faucibus. Pharetra vel turpis nunc eget lorem dolor sed. Aliquet nibh praesent tristique magna sit amet. In cursus turpis massa tincidunt dui ut ornare lectus sit. Quis hendrerit dolor magna eget est lorem ipsum. Facilisis gravida neque convallis a cras semper auctor neque. Fermentum dui faucibus in ornare quam viverra. Vitae elementum curabitur vitae nunc sed. Aliquet nibh praesent tristique magna sit amet purus. Id leo in vitae turpis massa sed elementum. Aliquam eleifend mi in nulla posuere sollicitudin aliquam ultrices. Amet venenatis urna cursus eget nunc scelerisque viverra mauris. A diam maecenas sed enim ut sem viverra aliquet. Pellentesque id nibh tortor id. Mattis rhoncus urna neque viverra justo. Auctor urna nunc id cursus metus aliquam. Rhoncus mattis rhoncus urna neque. Et odio pellentesque diam volutpat. Nec ultrices dui sapien eget mi proin sed libero enim. Eget nunc scelerisque viverra mauris in aliquam sem fringilla. Non consectetur a erat nam at lectus urna. Eu augue ut lectus arcu bibendum at varius vel pharetra.</p>

        <form action="game.php" method="post">
            <input type="hidden" name="language" value="english">
            <button class="play-button" type="submit">Play</button>
        </form>
        <a class="halloffame-button" href="game.php">Hall of Fame</a>
    </div>
    </div>
    <div class="languagesimages">
        <img src="imgs/españa.jpeg" alt="Imagen de la bandera de España" onclick="changeLanguage('spanish')">
        <img src="imgs/catalunya.jpeg" alt="Imagen de la bandera de Catalunya" onclick="changeLanguage('catalan')">
        <img src="imgs/uk.webp" alt="Imagen de la bandera del Reino Unido" onclick="changeLanguage('english')">
    </div>
    <footer>
        <p>© MCM S.A.</p>
        <p></p>
        <p></p>
    </footer>
</body>
</html>
