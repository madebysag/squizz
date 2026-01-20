<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/Take_Exam.css">
    <title>Take an Exam</title>
</head>
<body>
    <main>
        <form action="/exams/write" method="POST">
            <p class="text-lg text-condensed">Take an Exam</p>
            <div class="input-group">
                <label for="exam" class="text-sm">Exam Key</label>
                <input type="text" name="exam_key" id="exam" >

                <?php if(isset($error)) : ?>
                <div class="error"><?= $error ?></div>
                <?php endif; ?>

            </div>
            <button type="submit" class="submit btn-primary">Next <b>>></b></button>
        </form>
    </main>
</body>
</html>