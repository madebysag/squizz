<?php

use Framework\Session;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/Finish_Exam.css">
    <title>Exam Result</title>
</head>
<body>
    <main>
        <p class="text-lg text-condensed">Welldone! <?= explode(" ", $user["name"])[0] ?></p>
        <div>
            <p class="text-md">Exam Title</p>
            <p class="text-lg text-condensed"><?=  $exam->title ?></p>

        </div>
        <p class="text-sm">You scored</p>
        <p class="text-xxl"><?= $score ?>%</p>
        <p class="text-sm">Breakdown</p>
        <p class="text-md">+<span class="correct"><?= $correct ?></span> correct answers</p>
        <p class="text-md">-<span class="wrong"><?= $wrong ?></span> wrong answers</p>
        <!-- <p class="text-md">-<span class="wrong">NULL yet lol</span> unattempted questions</p> -->
        <div>
            <a class="btn-primary" href="/"><< Home Page</a>
        </div>
    </main>
</body>
</html>