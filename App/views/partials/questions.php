<?php
$pointer = 0;

$questions = array_keys($questions);
$questionIds = array_values($questions);
$answers = array_keys($answers);
$questionIds = array_values($answers);


?>

<?php foreach($questions as $id => $body) : ?>
<div class="question-container active" id="question_1">

    <section class="question">
        <p class="number">
            <span class="text-muted">Question </span>
            <b class="md">1</b>
        </p>
        <div class="question-body">
            <p class="text md">What is the best mesthod to center a div?</p>
            <div class="image"><img src="" alt=""></div>
        </div>
            
    </section>


    <section class="answers">
        
        <button type="button" class="btn-primary">Clear choices</button>

        <input type="radio" name="q1" id="q1a">
        <label class="option md" for="q1a">
            <span class="text-lg">A</span>
            Using flex box, place-items and justify-contents.
        </label>

        <input type="radio" name="q1" id="q1b">
        <label class="option md" for="q1b">
            <span class="text-lg">B</span>
            Using flex box, place-items and justify-contents.
        </label>

        <input type="radio" name="q1" id="q1c">
        <label class="option md" for="q1c">
            <span class="text-lg">C</span>
            Using flex box, place-items and justify-contents. Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, ab! Quam vel aliquam necessitatibus debitis dolores cupiditate dolor qui temporibus animi accusantium ad, porro nesciunt ipsa harum id quae quisquam.
        </label>

        <input type="radio" name="q1" id="q1d">
        <label class="option md" for="q1d">
            <span class="text-lg">D</span>
            Using flex box, place-items and justify-contents.
        </label>

    </section>
    
</div>
<?php endforeach; ?>