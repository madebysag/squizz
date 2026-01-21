<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/Exam_Instructions.css">
    <title>Exam Instructions</title>
</head>
<body>
    <main>
        <div class="exam-info">
            <p class="title text-condensed text-md"><?= $exam->title ?></p>
            <p class="author text-sm">by - <?= $exam->author ?></p>
        </div>
        
        <div class="exam-info">
            <p class="author text-sm">You can take this exam between <b><?= formatDate($exam->start_at) ?></b> to <b><?= formatDate($exam->end_at) ?></b></p>
        </div>
        
        <div class="exam-info">
            <div class="exam-details">
                <p class="text-md"><b><u><?= $exam->questions_count ?></u></b> Questions</p>
                <p class="text-md"><b><u><?= $exam->duration ?></u></b> minutes</p>
            </div>

            <div class="exam-instructions">
                <p class="text-sm"><b>Read all instructions carefully before starting the exam</b></p>
                <ol>

                    <?php foreach(explode("\n", $exam->instructions) as $line) : ?>
                    <li><?= $line ?></li>
                    <?php endforeach; ?>

                </ol>
            </div>
        </div>
        <a href="/exams/<?= $exam->exam_key ?>/start" class="submit btn-primary">Start Exam <b>>></b></a>
    </main>
</body>
</html>