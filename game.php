<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>¿Quién quiere ser millonario?</title>
</head>
<body>
    <?php
    function readQuestions($language) {
        $route = "questions/" . $language . ".txt";
        $content = file($route, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        echo "<p>{$content[0]}</p>";
        return $content;
    }

    function getRandomNumber($questions) {
        $longitud = count($questions);
        $numerosMultiplos = array();
    
        for ($i = 0; $i < $longitud; $i++) {
            if ($i % 5 == 0) {
                $numerosMultiplos[] = $i;
            }
        }
    
        $indiceAleatorio = array_rand($numerosMultiplos);
        return $numerosMultiplos[$indiceAleatorio];
    }

    function printQuestions($questions, $indice) {
        if ($indice < count($questions) - 4) {
            echo "<h1>" . $questions[$indice] . "</h1></br>";
            for ($i = $indice + 1; $i <= $indice + 4; $i++) {
                echo $questions[$i] . "</br>";
            }
            //echo $questions[$indice + 5] . "\n";
        } else {
            echo "Índice fuera de rango.\n";
        }
    }

    /* readQuestions('catalan_1.txt');
    function selectQuestions($question){

    } */

    /* function selectQuestions($questions, $amount) {
        $selectedQuestions = array_rand($questions, $amount);
        echo "<p>{$selectedQuestions[0]}</p>";
        echo "<p>{$selectedQuestions[1]}</p>";
        echo "<p>{$selectedQuestions[2]}</p>";
        $prueba = array_intersect_key($questions, array_flip($selectedQuestions));
        echo "<p>{$prueba}</p>";
        return array_intersect_key($questions, array_flip($selectedQuestions));
    } */
    /* selectQuestions(readQuestions('catalan_1.txt'),3);
    function printQuestion($question) {
        list($textoPregunta, $opciones) = explode("*", $question, 2);
        $opciones = explode('-', $opciones);
        
        echo "<p>{$textoPregunta}</p>";
        
        foreach ($opciones as $opcion) {
            echo "<input type='radio' name='respuesta' value='{$opcion}'> {$opcion}<br>";
        }
    } */
    
    $questions = readQuestions('catalan_1');
    //$selectedQuestion = selectQuestions($questions, 3);
    
    $selectedQuestion = getRandomNumber($questions);

    printQuestions($questions, $selectedQuestion);

    ?>

    <h1>¿Quién quiere ser millonario?</h1>
    <form action="game.php" method="post">
        <?php printQuestion(current($selectedQuestion)); ?>
        <input type="submit" name="siguiente" value="Siguiente Pregunta">
    </form>

    <?php
    if (isset($_POST['siguiente'])) {
        next($selectedQuestion);
        if (current($selectedQuestion)) {
            printQuestion(current($selectedQuestion));
        } else {
            echo "<p>¡Nivel completado!</p>";
        }
    }

    ?>
</body>
</html>