<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/Exam_Result.css">
    <title>Exam Results</title>
</head>
<body>
    <header>
        <p class="text-condensed text-sm">Welcome back <?= explode(" ", $user["name"])[0] ?>!</p>

        <?= loadPartial("logOutBtn") ?>

    </header>
    <aside>
        <a href="/exams/list" class="btn-primary">Exams</a>
        <a href="/exams/results" class="btn-primary active" disabled>Results</a>
        <a href="/exams/reports" class="btn-primary">Reports</a>
    </aside>
    <main>
        <div>
            <p class="text-md">
                <?= $exam->title ?> 
                &nbsp;&nbsp;&nbsp;&nbsp;
                <?= loadPartial("isExamLive", [
                    "exam"=> $exam
                ]) ?>
            </p>    
        </div>
        
        <div class="text-condensed">
            <div >
                <p class="text-lg"><?= $exam->questions_count ?></p>    
                <p class="text-sm">questions</p>
            </div>
            <div>
                <p class="text-lg"><?= $exam->duration ?></p>    
                <p class="text-sm">minutes</p>
            </div>
            <div>
                <p class="text-lg"><?= formatDate($exam->start_at, " - ") ?></p>    
                <p class="text-sm">Start Date and Time</p>
            </div>
            <div>
                <p class="text-lg"><?= formatDate($exam->end_at, " - ") ?></p>    
                <p class="text-sm">End Date and Time</p>
            </div>
            <div>
                <p class="text-lg"><?= $exam->exam_key ?></p>    
                <p class="text-sm">Exam Key</p>
            </div>
        </div>
        <div>
            <p class="text-md">Tags: <?= $exam->tags ?></p>
            <a href="/exams/<?= $exam->exam_key ?>/edit" class="btn-primary">Edit Exam</a>
        </div>

        <section class="table">
            <div class="t-head">
                <div class="t-rows">
                    <div>Name</div>
                    <div>Total</div>
                    <div>Correct</div>
                    <div>Wrong</div>
                    <div>Unattempted</div>
                    <div>Submitted on</div>
                </div>
            </div>
            <div class="t-body">

                <?php foreach($results as $result) : ?>
                    <div class="t-rows">
                        <div><?= $result->name ?></div>
                        <div class="text-blue text-lg"><?= $result->score ?>%</div>
                        <div><div> + <span class="text-blue"><?= $result->correct ?></span> </div></div>
                        <div><div> - <span class="text-red"><?= $result->wrong ?></span> </div></div>
                        <div><div> - <span class="text-red">null</span> </div></div>
                        <div><?= formatDate($result->updated_at, " - ") ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>


    </main>
</body>
</html>