<?php
$pointer = 0;

$options = [];




?>

<?php foreach($questions as $question) : ?>

    <?php 

        $pointer = 0;

        switch ($question->type) {
            case 'A-D':
                $options = ["A", "B", "C", "D"];
                break;
        
            case 'A-E':
                $options = ["A", "B", "C", "D", "E"];
                break;
            
            default:
                $options = ["T", "F"];
                break;
        }    
    ?>


    <div class="question-container <?= $question->number == 1 ? "active" : "" ?>" id="question_<?= $question->number ?>">

        <section class="question">
            <p class="number">
                <span class="text-muted">Question </span>
                <b class="md"><?= $question->number ?></b>
            </p>
            <div class="question-body">
                <p class="text md"><?= $question->body ?></p>
                <div class="image"><img src="<?= $question->picture_url ?>" alt=""></div>
            </div>
                
        </section>


        <section class="answers">
            
            <button type="button" class="btn-primary">Clear choices</button>

            <!-- Option Code Starts here -->
            <?php if ($question->type == "T/F") : ?> 
                True of false            
                
            <?php else : ?>
    
                <?php foreach($question->answers as $answer) : ?>
                    
                    <input type="radio" name="q<?= $question->number ?>" id="q<?= $question->number . strtolower($options[$pointer]) ?>">

                    <label class="option md" for="q<?= $question->number . strtolower($options[$pointer]) ?>">

                        <span class="text-lg"><?= $options[$pointer] ?></span>

                        <?= $answer->body ?>
                        
                    </label>
                    
                    <?php $pointer++  ?>

                <?php endforeach; ?>
            
            <?php endif; ?>

            <!-- Option Code Ends here -->

        </section>
        
    </div>

<?php endforeach; ?>