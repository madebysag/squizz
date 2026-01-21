<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/Public_Exams.css">
    <title>Public Exams</title>
</head>
<body>
    <header>
        <div class="header">
            <p class="text-condensed text-sm">MrQundus</p>
            <a href="#" class="btn-secondary">Logout</a>
        </div>
        <div class="search-container">
            <p class="text-condensed">Public Exams </p>
            <div>
                <form action="">
                    <input type="text" name="search_exam" id="search_exam" placeholder="Search by Tags, Title, Keywords...">
                </form>
                <button class="btn-primary">Take Private Exam</button>
            </div>
        </div>
    </header>
    <main>

        <?php if(isset($error)) : ?>

            <div class="container">
                <div class="wrapper">
                    <div href="#" class="text-md exam-link">
                        <?= $error ?>
                    </div>
                </div>
            </div>

        <?php else: ?>

            <?php foreach($exams as $exam) : ?>

                <div class="container">
                    <div class="wrapper">
                        <a href="#" class="text-sm exam-link">

                            <?= $exam->title ?>
                            
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <?php if (isExamLive($exam->start_at, $exam->end_at)) : ?> 
                            
                                <span class="text-blue">LIVE</span>
                            
                            <?php else : ?> 
                            
                                <span class="text-muted">UNALIVE</span>
                            
                            <?php endif; ?> 
                        </a>
                        <div>
                            <p class="text-muted">Author</p>
                            <p><?= $exam->author ?? "Anonymous" ?></p>
                        </div>
                        <div>
                            <p class="text-muted">Details</p>
                            <p><?= $exam->questions_count ?> questions <br> <?= $exam->duration ?> minutes</p>
                        </div>
                        <div>
                            <p class="text-muted">Start Date</p>
                            <p><?= formatDate($exam->start_at, "<br>") ?></p>
                        </div>
                        <div>
                            <p class="text-muted">End Date</p>
                            <p><?= formatDate($exam->end_at, "<br>") ?></p>
                        </div>
                    </div>
                    <p>Tags - <?= $exam->tags ?></p>
                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </main>
</body>
</html>