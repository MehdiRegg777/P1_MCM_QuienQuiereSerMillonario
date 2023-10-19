<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
</head>
<body>
    <?php
    $questions_3 = file('questions/catalan_1.txt', FILE_IGNORE_NEW_LINES);
    $selectedQuestions = array_rand($questions_3, 3);

    // Utiliza el índice obtenido para acceder a las preguntas seleccionadas
    echo '<h2>' . $questions_3[$selectedQuestions[0]] . '</h2>';
    echo '<h2>' . $questions_3[$selectedQuestions[1]] . '</h2>';
    echo '<h2>' . $questions_3[$selectedQuestions[2]] . '</h2>';

    echo '<form action="game.php" method="post">';
    ?>
</body>
</html>
