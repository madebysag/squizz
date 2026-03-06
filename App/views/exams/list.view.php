<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/Exam_List.css">
    <script type="module" src="/js/ExamList.index.js"></script>
    <title>Exam Lists</title>
</head>
<body>
    <header>
        <p class="text-condensed text-sm">Sqizz - the best way to quizz!</p>
        
        <?= loadPartial("logOutBtn") ?>
        
    </header>
    <aside>
        <a href="/exams/list" class="btn-primary active" disabled >Exams</a>
        <a href="/exams/results" class="btn-primary">Results</a>
        <a href="/exams/reports" class="btn-primary text-muted">Reports (comming soon)</a>
    </aside>

    <div class="modal-container">
        <form class="modal" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <p class="text-condensed text-md">Are you sure you want to delete?</p>
            <p class="text-lg delete-title">
                
            </p>
            <p class="text-sm">
                Deletion is permanent and all questions associated will be deleted 
            </p>
            <div>
                <button class="btn-secondary .btn-cancel" type="button">Cancel</button>
                <button class="btn-secondary text-red" type="submit">Delete</button>
            </div>
        </form>
    </div>

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
                        <div><?= loadPartial("isExamLive", ["exam" => $exam]) ?></div>
                        <div><div> <?= $exam->questions_count ?> <span class="text-muted">questions</span>  <br> <?= $exam->duration ?> <span class="text-muted">minutes</span> </div></div>
                        <div><?= formatDate($exam->start_at, "<br />") ?></div>
                        <div><?= formatDate($exam->end_at, "<br />") ?></div>
                        <div><?= $exam->exam_key ?></div>
                        <div>
                            <a href="/exams/<?= $exam->exam_key ?>" class="btn-secondary">Edit</a>
                            <button 
                                class="btn-secondary text-red delete-btn" 
                                data-key="<?= $exam->exam_key ?>"
                                data-title="<?= $exam->title ?>"
                                >
                                Delete
                            </button>
                        </div>
                    </div>

                <?php endforeach; ?>
                
            </div>
        </section>

    </main>
</body>
</html>