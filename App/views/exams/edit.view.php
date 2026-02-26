<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/Upload_Questions.css">
    <script type="module" src="/js/UploadQuestions.index.js"></script>
    <title>Edit Exam Questions</title>
</head>
<body>

    <header>
        <div class="username">Welcome back, <?= explode(" ", $user["name"])[0] ?></div>
        <a href="/exams/list" class="btn-secondary">Go To Exam List</a>
    </header>

    <form action="/exams/<?= $exam->exam_key ?>/edit" method="POST" >

        <input type="hidden" name="_method" value="PUT">

        <main>

            <?php foreach($questions as $question) : ?>

                <?php if ($question->type == "T/F") : ?>

                    <section class="question-container" id="question_<?= $question->number ?>" data-type="<?= $question->type ?>">

                        <input type="hidden" name="question_id_<?= $question->number ?>" value="<?= $question->id ?>">

                        <!-- Questions -->
                        <div class="question">
                            <input type="hidden" name="question_type_<?= $question->number ?>" value="<?= $question->type ?>">
                            <p class="number">
                                <span class="text-muted">Question </span>
                                <b><?= $question->number ?></b>
                            </p>

                            <div class="question-body">
                                <textarea name="question_<?= $question->number ?>" class="text-md"> <?= $question->body ?></textarea>
                                <div class="image"><img src="<?= $question->picture_url ?>" alt=""></div>
                            </div>
                            
                            <label class="btn-secondary upload-image-btn">Upload Picture <input type="file" name="question_image_<?= $question->number ?>" id="question_<?= $question->number ?>_image" accept=".png, .jpeg"></label>

                            <button type="button" class="btn-secondary delete-uploaded-image">Delete Picture</button>
                                
                        </div>

                        
                        <!-- Options -->
                        <p class="text-condensed text-sm text-muted">Options</p>

                        <div class="answers">

                        <?php $correctOption = $question->answers[0]->body ?>
                            
                        <input type="hidden" name="answer_id_<?= $question->number ?>" value="<?= $question->answers[0]->id ?>">

                        <div>
                            <span class="text-lg text-muted">T</span>
                            <textarea class="text-md" name="answer_T_<?= $question->number ?>" disabled="">TRUE</textarea>
                            <label class="btn-secondary">
                                ( <input type="radio" value="T" name="correct_answer_<?= $question->number ?>" id="question_option_<?= $question->number ?>T" <?= $correctOption == "T" ? "checked" : "" ?> /> ) Correct Answer
                            </label>
                        </div>
                        <div>
                            <span class="text-lg text-muted">F</span>
                            <textarea class="text-md" name="answer_F_<?= $question->number ?>" disabled="">FALSE</textarea>
                            <label class="btn-secondary">
                                ( <input type="radio" value="F" name="correct_answer_<?= $question->number ?>" id="question_option_<?= $question->number ?>F" <?= $correctOption == "F" ? "checked" : "" ?> > ) Correct Answer
                            </label>
                        </div>
                        </div>
                        
                    </section>

                <?php else : ?>

                    <section class="question-container" id="question_<?= $question->number ?>" data-type="<?= $question->type ?>">

                        <input type="hidden" name="question_id_<?= $question->number ?>" value="<?= $question->id ?>">

                        <!-- Questions -->
                        <div class="question">
                            <input type="hidden" name="question_type_<?= $question->number ?>" value="<?= $question->type ?>">
                            <p class="number">
                                <span class="text-muted">Question </span>
                                <b><?= $question->number ?></b>
                            </p>

                            <div class="question-body">
                                <textarea name="question_<?= $question->number ?>" class="text-md"><?= $question->body ?></textarea>
                                <div class="image"><img src="<?= $question->picture_url ?>" alt=""></div>
                            </div>
                            
                            <label class="btn-secondary upload-image-btn">Upload Picture <input type="file" name="question_image_<?= $question->number ?>" id="question_<?= $question->number ?>_image" accept=".png, .jpeg"></label>

                            <button type="button" class="btn-secondary delete-uploaded-image">Delete Picture</button>
                                
                        </div>

                        
                        <!-- Options -->
                        <p class="text-condensed text-sm text-muted">Options</p>

                        <div class="answers">
                            
                            <?php $counter = 0; $option = ["A", "B", "C", "D", "E"] ?>
                            <?php foreach($question->answers as $answer) : ?>
                                
                                <div>

                                    <input type="hidden" name="answer_id_<?= $question->number . $option[$counter] ?>" value="<?= $answer->id ?>">

                                    <span class="text-lg text-muted"><?= $option[$counter] ?></span>
                                    <textarea class="text-md" name="answer_<?= $option[$counter] . "_" . $question->number ?>"> <?= $answer->body ?> </textarea>
                                    <label class="btn-secondary">
                                        ( <input type="radio" value="<?= $option[$counter] ?>" name="correct_answer_<?= $question->number ?>" id="question_option_<?= $question->number . $option[$counter] ?>" <?= $answer->is_correct == 1 ? "checked" : "" ?> /> ) Correct Answer
                                    </label>
                                </div>

                                <?php $counter++; ?>

                            <?php endforeach ?>
                            

                        </div>
                        
                    </section>
                <?php endif; ?>

            <?php endforeach; ?>
            
        </main>
        
        <?= loadPartial("createExamSideBar", [
            "questions" => $questions,
            "exam" => $exam,
            "saveRoute" => "/exams/" . $exam->exam_key . "/edit"
        ]) ?>
            
    </form>

</body>
</html>