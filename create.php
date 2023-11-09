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
            <?php
            echo "<div id='message' style='display: none;'></div>";
            if ($_SESSION['language'] === 'spanish') {
                echo '<h2>Crear nueva pregunta</h2>';
                echo '<form action="create.php" method="post" enctype="multipart/form-data">';
                echo '    <label for="idioma">Idioma:</label>';
                echo '    <select name="idioma" required>';
                echo '        <option value="spanish">Español</option>';
                echo '        <option value="catalan">Catalán</option>';
                echo '        <option value="english">Inglés</option>';
                echo '    </select><br>';
                
                echo '    <label for="nivel">Nivel:</label>';
                echo '    <select name="nivel" required>';
                echo '        <option value="1">Nivel 1</option>';
                echo '        <option value="2">Nivel 2</option>';
                echo '        <option value="3">Nivel 3</option>';
                echo '        <option value="4">Nivel 4</option>';
                echo '        <option value="5">Nivel 5</option>';
                echo '        <option value="6">Nivel 6</option>';
                echo '    </select><br>';
                
                echo '    <label for="pregunta">Pregunta:</label>';
                echo '    <textarea name="pregunta" rows="4" cols="50" required></textarea><br>';
                
                echo '    <label for="opcionA">Respuesta Opción A:</label>';
                echo '    <input type="radio" name="respuesta" value="A" required><br>';
                echo '    <textarea name="opcionA" rows="4" cols="50" required></textarea>';
                
                echo '    <label for="opcionB">Respuesta Opción B:</label>';
                echo '    <input type="radio" name="respuesta" value="B" required><br>';
                echo '    <textarea name="opcionB" rows="4" cols="50" required></textarea>';
                
                echo '    <label for="opcionC">Respuesta Opción C:</label>';
                echo '    <input type="radio" name="respuesta" value="C" required><br>';
                echo '    <textarea name="opcionC" rows="4" cols="50" required></textarea>';
                
                echo '    <label for="opcionD">Respuesta Opción D:</label>';
                echo '    <input type="radio" name="respuesta" value="D" required><br>';
                echo '    <textarea name="opcionD" rows="4" cols="50" required></textarea>';

                echo '    <label for="imagen">Subir Imagen:</label>'; 
                echo '    <input type="file" name="imagen" id="imagen" ><br>';
                echo '    <br>';
                echo '    <input type="submit" id="crearPregunta" value="Crear Pregunta">';
                echo '</form>';
   
            } elseif ($_SESSION['language'] === 'catalan') {
                echo '<h2>Crear nova pregunta</h2>';
                echo '<form action="create.php" method="post">';
                echo '    <label for="idioma">Idioma:</label>';
                echo '    <select name="idioma" required>';
                echo '        <option value="spanish">Espanyol</option>';
                echo '        <option value="catalan">Català</option>';
                echo '        <option value="english">Anglès</option>';
                echo '    </select><br>';
                
                echo '    <label for="nivel">Nivell:</label>';
                echo '    <select name="nivel" required>';
                echo '        <option value="1">Nivell 1</option>';
                echo '        <option value="2">Nivell 2</option>';
                echo '        <option value="3">Nivell 3</option>';
                echo '        <option value="4">Nivell 4</option>';
                echo '        <option value="5">Nivell 5</option>';
                echo '        <option value="6">Nivell 6</option>';
                echo '    </select><br>';
                
                echo '    <label for="pregunta">Pregunta:</label>';
                echo '    <textarea name="pregunta" rows="4" cols="50" required></textarea><br>';
                
                echo '    <label for="opcionA">Resposta Opció A:</label>';
                echo '    <input type="radio" name="respuesta" value="A" required><br>';
                echo '    <textarea name="opcionA" rows="4" cols="50" required></textarea>';
                
                echo '    <label for="opcionB">Resposta Opció B:</label>';
                echo '    <input type="radio" name="respuesta" value="B" required><br>';
                echo '    <textarea name="opcionB" rows="4" cols="50" required></textarea>';
                
                echo '    <label for="opcionC">Resposta Opció C:</label>';
                echo '    <input type="radio" name="respuesta" value="C" required><br>';
                echo '    <textarea name="opcionC" rows="4" cols="50" required></textarea>';
                
                echo '    <label for="opcionD">Resposta Opció D:</label>';
                echo '    <input type="radio" name="respuesta" value="D" required><br>';
                echo '    <textarea name="opcionD" rows="4" cols="50" required></textarea>';

                echo '    <label for="imagen">Pujar Imatge:</label>'; 
                echo '    <input type="file" name="imagen" id="imagen" ><br>';
                echo '    <br>';
                echo '    <input type="submit" value="Crear Pregunta">';
                echo '</form>';
            } elseif ($_SESSION['language'] === 'english') {
                echo '<h2>Create new question</h2>';
                echo '<form action="create.php" method="post">';
                echo '    <label for="idioma">Language:</label>';
                echo '    <select name="idioma" required>';
                echo '        <option value="spanish">Spanish</option>';
                echo '        <option value="catalan">Catalan</option>';
                echo '        <option value="english">English</option>';
                echo '    </select><br>';
                
                echo '    <label for="nivel">Level:</label>';
                echo '    <select name="nivel" required>';
                echo '        <option value="1">Level 1</option>';
                echo '        <option value="2">Level 2</option>';
                echo '        <option value="3">Level 3</option>';
                echo '        <option value="4">Level 4</option>';
                echo '        <option value="5">Level 5</option>';
                echo '        <option value="6">Level 6</option>';
                echo '    </select><br>';
                
                echo '    <label for="pregunta">Question:</label>';
                echo '    <textarea name="pregunta" rows="4" cols="50" required></textarea><br>';
                
                echo '    <label for="opcionA">Answer Option A:</label>';
                echo '    <input type="radio" name="respuesta" value="A" required><br>';
                echo '    <textarea name="opcionA" rows="4" cols="50" required></textarea>';
                
                echo '    <label for="opcionB">Answer Option B:</label>';
                echo '    <input type="radio" name="respuesta" value="B" required><br>';
                echo '    <textarea name="opcionB" rows="4" cols="50" required></textarea>';
                
                echo '    <label for="opcionC">Answer Option C:</label>';
                echo '    <input type="radio" name="respuesta" value="C" required><br>';
                echo '    <textarea name="opcionC" rows="4" cols="50" required></textarea>';
                
                echo '    <label for="opcionD">Answer Option D:</label>';
                echo '    <input type="radio" name="respuesta" value="D" required><br>';
                echo '    <textarea name="opcionD" rows="4" cols="50" required></textarea>';
                
                echo '    <label for="imagen">Upload Image:</label>'; 
                echo '    <input type="file" name="imagen" id="imagen" ><br>';
                echo '    <br>';
                echo '    <input type="submit" value="Create Question">';
                echo '</form>';
            }
            if ($_SESSION['language'] === 'spanish') {
                echo '<a class="play-button" href="index.php"><em>Cerrar Sesión</em></a>';
            } elseif ($_SESSION['language'] === 'catalan') {
                echo "<a class='play-button' href='index.php'><em>Tancar Sessió</em></a>";
            } elseif ($_SESSION['language'] === 'english') {
                echo '<a class="play-button" href="index.php"><em>Sign Off</em></a>';             
            }
            ?>
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

                if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == UPLOAD_ERR_OK) {

                    $imagen_info = pathinfo($_FILES["imagen"]["name"]);
                    $imagen_extension = $imagen_info["extension"];

                    $nombre_imagen = "imagen_" . time() . "." . $imagen_extension;
        
                    $ruta_imagen = "/imagGame/" . $nombre_imagen;
        
                    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $_SERVER["DOCUMENT_ROOT"] . $ruta_imagen)) {
                        $pregunta_con_imagen = "# " . $ruta_imagen . "\n";
                        $pregunta_con_imagen .= "* " . $pregunta;
                    } else {
                        echo "<script>alert('Error al subir la imagen.');</script>";
                        exit; 
                    }
                } else {
                    $pregunta_con_imagen = "# /imagGame/imagen_No_existe" . "\n";
                    $pregunta_con_imagen .= "* " . $pregunta;
                }
        
                $nueva_pregunta = $pregunta_con_imagen . "\n";
        
                foreach ($opciones as $opcion => $texto) {
                    if ($respuesta == $opcion) {
                        $nueva_pregunta .= "+ " . $texto . "\n";
                    } else {
                        $nueva_pregunta .= "- " . $texto . "\n";
                    }
                }
        
                $archivo = "questions/" . $idioma . "_" . $nivel . ".txt";
        
                $file = fopen($archivo, "a");
                if ($file) {
                    fwrite($file, "\n" . $nueva_pregunta);
                    fclose($file);
                    if ($_SESSION['language'] === 'spanish') {
                        echo "<script>alert('Pregunta creada con éxito.');</script>";
                    } elseif ($_SESSION['language'] === 'catalan') {
                        echo "<script>alert(Pregunta creada amb èxit.');</script>";
                    } elseif ($_SESSION['language'] === 'english') {
                        echo "<script>alert('Question created successfully.');</script>";
                    }
                } else {
                    echo "<script>alert('Error al abrir el archivo.');</script>";
                }
            }
        }
        ?>

        <footer class='footerinfo'>
            <p>© MCM S.A.</p>
            <p><a href='gmail.com'>Contact us</a></p>
            <p><a href='instagram.com'>Follow us</a></p>
        </footer>
        <script src='funcionGame.js'></script>
    </body>
</html>