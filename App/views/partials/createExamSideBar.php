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
                <input type="text" name="title" class="text-sm" id="exam_title" value="<?= $exam->title ?>" >
                
                <label for="course_name" class="text-condensed text-muted text-sm">Course / Subject</label>
                <input type="text" name="course" class="text-sm" id="course_name" value="<?= $exam->course ?>" >
                
                <label for="exam_tags" class="text-condensed text-muted text-sm">Tags</label>
                <input type="text" name="tags" class="text-sm" id="exam_tags" value="<?= $exam->tags ?>" >

                <label for="exam_author" class="text-condensed text-muted text-sm">Show Author's Name</label>
                <input type="checkbox" name="show_author" value="<?= $exam->show_author ?>" class="text-sm" id="exam_author" >
                
            </div>
            
            <div class="" id="timing">
                
                <label for="exam_duration" class="text-condensed text-muted text-sm">Exam Duration - in minutes*</label>
                <input type="number" name="duration" class="text-sm" id="exam_duration" value="<?= $exam->duration ?>" >
                
                <label for="exam_start" class="text-condensed text-muted text-sm">Exam Start / Commence - Date and Time</label>
                <input type="datetime-local" name="start_at" class="text-sm" id="exam_start" value="<?= $exam->start_at ?>" >

                <label for="exam_end" class="text-condensed text-muted text-sm">Exam Period End - Date and Time</label>
                <input type="datetime-local" name="end_at" class="text-sm" id="exam_end" value="<?= $exam->end_at ?>" >

            </div>
            <div class="" id="instructions">
                <label for="exam_instructions" class="text-condensed text-muted text-sm">Please write each instruction on a new line</label>
                <textarea name="instructions" id="exam_instructions"><?= $exam->instructions ?></textarea>
            </div>
            <div class="" id="goto">

                <?php foreach($questions as $question) : ?>

                    <a href="#question_<?= $question->number ?>" class="goto text-muted"><?= $question->number ?></a>

                <?php endforeach; ?>

            </div>
        </div>
    </div>
    
    <div class="actions">
        <p class="text-condensed text-muted text-sm">Records</p>
        <p class="text-muted text-sm">* Note that Saving does not make the exam go live, it only keep the current records. To go live, use Publish button.</p>
        <button class="btn-secondary" data-action="/exams/delete" >Delete</button>
        <button type="submit" class="btn-primary" data-action="<?= $saveRoute ?>" >Save</button>
    </div>
    
    <div class="actions">
        <p class="text-condensed text-muted text-sm">Go Live</p>
        <p class="text-muted text-sm">* Publishing will make the exam go live and accessible by student</p>
        <button class="btn-secondary" data-action="/exams/unpublish">Unpublish</button>
        <button class="btn-primary" data-action="/exams/publish" >Publish</button>
    </div>
</aside>