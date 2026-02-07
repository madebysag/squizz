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
        <div class="username">Mr Qundus</div>
        <a class="btn-secondary">Go to Profile</a>
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
        
        <aside>
            <div class="tabs-container">

                <div class="tabs-title">
                    <button type="button" class="btn-primary active" data-tab-id="meta_data">Meta Data</button>
                    <button type="button" class="btn-primary" data-tab-id="timing">Timing and Duration</button>
                    <button type="button" class="btn-primary" data-tab-id="instructions">Exam Instructions</button>
                    <button type="button" class="btn-primary" data-tab-id="goto">Go to Question</button>
                </div>

                <div class="tabs">

                    <div class="active" id="meta_data">

                        <label for="exam_title" class="text-condensed text-muted text-sm">Title</label>
                        <input type="text" name="title" class="text-sm" id="exam_title">
                        
                        <label for="course_name" class="text-condensed text-muted text-sm">Course / Subject</label>
                        <input type="text" name="course" class="text-sm" id="course_name">
                        
                        <label for="exam_tags" class="text-condensed text-muted text-sm">Tags</label>
                        <input type="text" name="tags" class="text-sm" id="exam_tags">

                        <label for="exam_author" class="text-condensed text-muted text-sm">Show Author's Name</label>
                        <input type="checkbox" name="show_author" value="1" class="text-sm" id="exam_author">
                        
                    </div>
                    
                    <div class="" id="timing">
                        
                        <label for="exam_duration" class="text-condensed text-muted text-sm">Exam Duration - in minutes*</label>
                        <input type="number" name="duration" class="text-sm" id="exam_duration">
                        
                        <label for="exam_start" class="text-condensed text-muted text-sm">Exam Start / Commence - Date and Time</label>
                        <input type="datetime-local" name="start_at" class="text-sm" id="exam_start">

                        <label for="exam_end" class="text-condensed text-muted text-sm">Exam Period End - Date and Time</label>
                        <input type="datetime-local" name="end_at" class="text-sm" id="exam_end">

                    </div>
                    <div class="" id="instructions">
                        <label for="exam_instructions" class="text-condensed text-muted text-sm">Please write each instruction on a new line</label>
                        <textarea name="instructions" id="exam_instructions"></textarea>
                    </div>
                    <div class="" id="goto">
                        <a href="#question_1" class="goto text-muted">1</a>
                    </div>
                </div>
            </div>
            
            <div class="actions">
                <p class="text-condensed text-muted text-sm">Records</p>
                <p class="text-muted text-sm">* Note that Saving does not make the exam go live, it only keep the current records. To go live, use Publish button.</p>
                <button class="btn-secondary" data-action="/exams/delete" >Delete</button>
                <button type="submit" class="btn-primary" data-action="/exams" >Save</button>
            </div>
            
            <div class="actions">
                <p class="text-condensed text-muted text-sm">Go Live</p>
                <p class="text-muted text-sm">* Publishing will make the exam go live and accessible by student</p>
                <button class="btn-secondary" data-action="/exams/unpublish">Unpublish</button>
                <button class="btn-primary" data-action="/exams/publish" >Publish</button>
            </div>
        </aside>
            
    </form>

</body>
</html>