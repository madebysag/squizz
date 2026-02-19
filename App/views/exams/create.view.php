<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/Upload_Questions.css">
    <script type="module" src="/js/UploadQuestions.index.js"></script>
    <title>Upload Questions</title>
</head>
<body>

    <header>
        <div class="username">Welcome back, <?= explode(" ", $user["name"])[0] ?></div>
        <a href="/exams/list" class="btn-secondary">Go To Exam List</a>
    </header>

    <form action="/exams" method="POST" >

        <main>
            
            <section class="question-container" id="question_1" data-type="A-D">

                <!-- Questions -->
                <div class="question">
                    <input type="hidden" name="question_type_1" value="A-D">
                    <p class="number">
                        <span class="text-muted">Question </span>
                        <b>1</b>
                    </p>
                    <button type="button" class="btn-secondary delete-question" data-id="question_1">Delete Question</button>

                    <div class="question-body">
                        <textarea name="question_1" class="text-md"></textarea>
                        <div class="image"><img src="" alt=""></div>
                    </div>
                    
                    <label class="btn-secondary upload-image-btn">Upload Picture <input type="file" name="question_image_1" id="question_1_image" accept=".png, .jpeg"></label>

                    <button type="button" class="btn-secondary delete-uploaded-image">Delete Picture</button>
                        
                </div>

                
                <!-- Options -->
                <p class="text-condensed text-sm text-muted">Options</p>

                <div class="answers">
                    
                <div>
                    <span class="text-lg text-muted">A</span>
                    <textarea class="text-md" name="answer_A_1"></textarea>
                    <label class="btn-secondary">
                        ( <input type="radio" value="A" name="correct_answer_1" id="question_option_1A"> ) Correct Answer
                    </label>
                </div>
                <div>
                    <span class="text-lg text-muted">B</span>
                    <textarea class="text-md" name="answer_B_1"></textarea>
                    <label class="btn-secondary">
                        ( <input type="radio" value="B" name="correct_answer_1" id="question_option_1B"> ) Correct Answer
                    </label>
                </div>
                <div>
                    <span class="text-lg text-muted">C</span>
                    <textarea class="text-md" name="answer_C_1"></textarea>
                    <label class="btn-secondary">
                        ( <input type="radio" value="C" name="correct_answer_1" id="question_option_1C"> ) Correct Answer
                    </label>
                </div>
                <div>
                    <span class="text-lg text-muted">D</span>
                    <textarea class="text-md" name="answer_D_1"></textarea>
                    <label class="btn-secondary">
                        ( <input type="radio" value="D" name="correct_answer_1" id="question_option_1D"> ) Correct Answer
                    </label>
                </div>
                </div>
                
            </section>

            <div class="actions add-question-container">
                <p class="text-condensed text-muted text-sm">Add Questions</p>
                <button type="button" class="btn-secondary" data-type="A-D">Four Options A - D</button>
                <button type="button" class="btn-secondary" data-type="A-E">Five Options A - E </button>
                <button type="button" class="btn-secondary" data-type="T/F">True / False</button>
            </div>
        </main>
        
        <?= loadPartial("createExamSideBar", [
            "saveRoute" => "/exams"
        ]) ?>
            
    </form>

</body>
</html>