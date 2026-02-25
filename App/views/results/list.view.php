<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/Exam_List.css">
    <title>Exam Results</title>
</head>
<body>
    <header>
        <p class="text-condensed text-sm">Sqizz - the best way to quizz!</p>
        
        <?= loadPartial("logOutBtn") ?>
        
    </header>
    <aside>
        <a href="/exams/list" class="btn-primary" >Exams</a>
        <a href="/exams/results" class="btn-primary active" disabled>Results</a>
        <a href="/exams/reports" class="btn-primary text-muted">Reports (comming soon)</a>
    </aside>
    <main>
        <div>
            <p class="text-md">Welcome, <?= explode(" ", $tutor["name"])[0] ?></p>
            <a href="/exams/create" class="btn-primary">Create Exam</a>
        </div>

        <section class="table">
            <div class="t-head">
                <div class="t-rows">
                    <div>Exam Title</div>
                    <div>Status</div>
                    <div>Details</div>
                    <div>Start</div>
                    <div>End</div>
                    <div>Key</div>
                    <div>Action</div>
                </div>
            </div>
            <div class="t-body">

                <?php foreach($exams as $exam) :?>

                    <div class="t-rows">
                        <div><?= $exam->title ?></div>
                        <div><?= loadPartial("isExamLive") ?></div>
                        <div><div> <?= $exam->questions_count ?> <span class="text-muted">questions</span>  <br> <?= $exam->duration ?> <span class="text-muted">minutes</span> </div></div>
                        <div><?= formatDate($exam->start_at, "<br />") ?></div>
                        <div><?= formatDate($exam->end_at, "<br />") ?></div>
                        <div><?= $exam->exam_key ?></div>
                        <div><a href="/exams/results/<?= $exam->exam_key ?>" class="btn-secondary">Results</a></div>
                    </div>

                <?php endforeach; ?>
                
            </div>
        </section>

    </main>
</body>
</html>