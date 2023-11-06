<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>¿Quién quiere ser millonario?</title>
        <meta author="" content="Claudia, Mehdi i Marcelo (2n DAW)">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="style.css" rel="stylesheet">
        <link rel="shortcut icon" href="imgs/logo.png" />
    </head>
    <body class="losePage">
    <header>
            <?php
                if ($_SESSION['language'] === 'spanish') {
                    echo "<a href='/index.php'><h1>¿Quién quiere ser millonario?</h1></a>";
                } elseif ($_SESSION['language'] === 'catalan') {
                    echo "<a href='/index.php'><h1>Qui vol ser milionari?</h1></a>";
                } elseif ($_SESSION['language'] === 'english') {
                    echo "<a href='/index.php'><h1>Who wants to be a millonarie?</h1></a>";
                }
            ?>
        </header>
        <div class="forumCreate">
            <h2>Crear Nueva Pregunta</h2>
            <form action="create.php" method="post">
                <label for="idioma">Idioma:</label>
                <select name="idioma" required>
                    <option value="spanish">Español</option>
                    <option value="catalan">Catalán</option>
                    <option value="english">Inglés</option>
                </select><br>

                <label for="nivel">Nivel:</label>
                <select name="nivel" required>
                    <option value="1">Nivel 1</option>
                    <option value="2">Nivel 2</option>
                    <option value="3">Nivel 3</option>
                    <option value="4">Nivel 4</option>
                    <option value="5">Nivel 5</option>
                    <option value="6">Nivel 6</option>
                </select><br>

                <label for="pregunta">Pregunta:</label>
                <textarea name="pregunta" rows="4" cols="50" required></textarea><br>

                <label for="opcionA">Respuesta Opción A:</label>
                <input type="radio" name="respuesta" value="A" required><br>
                <textarea name="opcionA" rows="4" cols="50" required></textarea>
              

                <label for="opcionB">Respuesta Opción B:</label>
                <input type="radio" name="respuesta" value="B" required><br>
                <textarea name="opcionB" rows="4" cols="50" required></textarea>

                <label for="opcionC">Respuesta Opción C:</label>
                <input type="radio" name="respuesta" value="C" required><br>
                <textarea name="opcionC" rows="4" cols="50" required></textarea>

                <label for="opcionD">Respuesta Opción D:</label>
                <input type="radio" name="respuesta" value="D" required><br>
                <textarea name="opcionD" rows="4" cols="50" required></textarea>

                <input type="submit" value="Crear Pregunta">
            </form>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idioma = $_POST["idioma"];
            $nivel = $_POST["nivel"];
            $pregunta = $_POST["pregunta"];
            $respuesta = $_POST["respuesta"];
            $opciones = [
                "A" => $_POST["opcionA"],
                "B" => $_POST["opcionB"],
                "C" => $_POST["opcionC"],
                "D" => $_POST["opcionD"]
            ];

            if (empty($pregunta) || empty($respuesta) || in_array("", $opciones)) {
                echo "Por favor, complete todas las opciones y la pregunta.";
            } else {
                $nueva_pregunta = "# /imagGame/question100.png" . "\n"; 
                $nueva_pregunta .= "* " . $pregunta . "\n";

                foreach ($opciones as $opcion => $texto) {
                    if ($respuesta == $opcion) {
                        $nueva_pregunta .= "+ " . $texto . "\n";
                    } else {
                        $nueva_pregunta .= "- " . $texto . "\n";
                    }
                }

                $archivo = "questions/".$idioma . "_" . $nivel . ".txt";

                $file = fopen($archivo, "a");
                if ($file) {
                    fwrite($file, "\n".$nueva_pregunta);
                    fclose($file);
                    echo "Pregunta creada con éxito.";
                } else {
                    echo "Error al abrir el archivo.";
                }
            }
        } 
        ?>


        <footer class='footerinfo'>
            <p>© MCM S.A.</p>
            <p><a href='gmail.com'>Contact us</a></p>
            <p><a href='instagram.com'>Follow us</a></p>
        </footer>
        <script src='funcionGame.js'></script>;
    </body>
</html>