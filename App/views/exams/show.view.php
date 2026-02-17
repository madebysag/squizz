<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/Exam.css">
    <script type="module" src="/js/Exam.index.js"></script>
    <title>Exam | <?= $exam->title ?></title>
</head>
<body>

    <header>
        <div class="timer-container">
            <p data-total-minutes="<?= $exam->duration ?>" class="timer text-condensed text-xl">00:00:00</p>
        </div>
        <div class="progress-container">

            <div class="progress">

                <div class="progress-bar">
                    <div class="bar"></div>
                </div>

                <div class="questions-stats">
                    <p class="sm">0 <span class="text-muted">answered</span></p>
                    <p class="sm">0 <span class="text-muted">left</span></p>
                </div>

            </div>

        </div>
    </header>

    <main>

        <form action="/exams/results/<?= $exam->exam_key ?>" method="POST">
            
            <?= loadPartial("questions", [
                "exam" => $exam,
                "questions" => $questions
            ]) ?>

            <!-- Finish Attempt Section -->
             <div class="finish-attempt-container">
                 
                <section class="finish-attempt">
                    <div class="confirmation">
                        <p class="text-condensed text-lg">Are you sure you want to submit?</p>
                        <div class="timer-container">
                            Time remaining:
                            <p>
                                 <span class="text-condensed text-xl">00:00:00</span>
                            </p>
                        </div>
                        <div class="progress-container">

                            <div class="progress">

                                <div class="progress-bar">
                                    <div class="bar"></div>
                                </div>

                                <div class="questions-stats">
                                    <p class="sm">0 <span class="text-muted">answered</span></p>
                                    <p class="sm">0 <span class="text-muted">left</span></p>
                                </div>

                            </div>

                        </div>
                    </div>
    
                    <nav class="goto-questions">
                        <!-- <button class="goto">1</button> -->
                    </nav>
                    
                    <div class="actions">
                        <button id="goBack" class="btn-primary"> << Go Back</button>
                        <button type="submit" class="btn-primary">Submit</button>
                    </div>
                 </section>

             </div>
            
        </form>

    </main>

    <footer>
        <button class="btn-primary"> << Previous</button>
        <nav class="goto-questions">
            <!-- <button class="goto">1</button> -->
        </nav>
        <button class="btn-primary">Next >> </button>
    </footer>
</body>
</html>