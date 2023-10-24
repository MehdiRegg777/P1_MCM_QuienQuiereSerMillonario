<!DOCTYPE html>
<html lang="en">
<html>
    <head>
        <title>¿Quién quiere ser millonario?</title>
        <meta author="" content="Claudia, Mehdi i Marcelo (2n DAW)">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="style.css" rel="stylesheet">
        <link rel="shortcut icon" href="imgs/logo.png" />
    </head>
    <body>
        <header>
            <h1>¿Quién quiere ser millonario?</h1>
        </header>
        <h3>Clasificaciones</h3><br>
    <table border="1">
    <tr>
        <th>Nombre</th>
        <th>Puntos</th>
        <th>ID</th>
    </tr>

    <?php
        // Ruta del archivo de registros
        $archivo = "records.txt";

        // Verifica si el archivo existe
        if (file_exists($archivo)) {
            // Abre el archivo para lectura
            $handle = fopen($archivo, "r");

            // Inicializa un array para almacenar los datos
            $data = array();

            // Recorre el archivo línea por línea
            while (($line = fgets($handle)) !== false) {
                // Divide la línea en sus partes separadas por comas
                $parts = explode(",", $line);

                // Verifica que haya tres partes
                if (count($parts) == 3) {
                    // Asigna las partes a variables
                    $nombre = $parts[0];
                    $puntos = (int)$parts[1]; // Convierte los puntos a entero
                    $id = $parts[2];

                    // Almacena los datos en el array
                    $data[] = array('nombre' => $nombre, 'puntos' => $puntos, 'id' => $id);
                }
            }

            // Cierra el archivo
            fclose($handle);

            // Ordena el array por la columna de puntos
            usort($data, function($a, $b) {
                return $b['puntos'] - $a['puntos'];
            });

            // Imprime la tabla ordenada
            
            foreach ($data as $row) {
                echo "<tr>";
                echo "<td>{$row['nombre']}</td>";
                echo "<td>{$row['puntos']}</td>";
                echo "<td>{$row['id']}</td>";
                echo "</tr>";
            }

        } else {
            echo "El archivo no existe.";
        }
        ?>


</table>

    <a class="play-button" href="index.php">Volver al inicio</a>
    </body>
</html>
