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
            <?php #inspect($_SESSION, false) ?>
            <?php #inspect($user, false) ?>
            <?php #inspect($admin, false) ?>
            <?php if(isset($user)) : ?>
                
                <p class="text-condensed text-sm">Hello <?= explode(" ", $user["name"])[0] ?></p>
                
                
                <form action="/auth/users/logout" method="POST">
                    <?php if($user["role"] == "tutor") : ?>
                        <a href="/exams/list" class="btn-secondary">Exam List</a>
                    <?php endif; ?>
                    <button type="submit" class="btn-secondary">Log out</button>
                </form>

            <?php elseif(isset($admin)) : ?>

                <p class="text-condensed text-sm">Hello <?= explode(" ", $admin["name"])[0] ?> administrator</p>

                <form action="/auth/organisations/logout" method="POST">
                    <button type="submit" class="btn-secondary">Log out</button>
                </form>

            <?php else: ?>
                    
                <p class="text-condensed text-sm">Hello there, take some Squizz!</p>
                
                <div>
                    <a href="/auth/users/login" class="btn-secondary">Log in</a>
                    <a href="/auth/organisations/login" class="btn-secondary">Admin Board</a>
                </div>

            <?php endif; ?>

        </div>
        <div class="search-container">
            <p class="text-condensed">Public Exams </p>
            <div>
                <form action="">
                    <input type="text" name="search_exam" id="search_exam" placeholder="Search by Tags, Title, Keywords...">
                </form>

                <?php if (isset($user) && $user["role"] == "tutor") : ?>

                    <a href="/exams/create" class="btn-primary">Create Exam</a>

                <?php else : ?>

                    <a href="/exams/write" class="btn-primary">Take Private Exam</a>

                <?php endif; ?>

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
                    <form method="POST" action="/exams/write" class="wrapper">
                        <input type="hidden" name="exam_key" value="<?= $exam->exam_key ?>">

                        <button type="submit" class="text-sm exam-link">

                            <?= $exam->title ?>
                            
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <?php if (isExamLive($exam->start_at, $exam->end_at)) : ?> 
                            
                                <span class="text-blue">LIVE</span>
                            
                            <?php else : ?> 
                            
                                <span class="text-muted">UNALIVE</span>
                            
                            <?php endif; ?> 
                            </button>
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
                    </form>
                    <p>Tags - <?= $exam->tags ?></p>
                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </main>
</body>
</html>