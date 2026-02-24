<?php

namespace Framework;

use Framework\Sorting\Question;
use Framework\Sorting\Answer;

/**
 * Sort and arrange questions, answers and meta data submited
 */

class Sorter {
    public static function sort(array $dataArray, string $pattern = "/\d+/") {

        $sortedArray = [];  

        foreach($dataArray as $key => $value) {
            if (preg_match($pattern, $key, $matches)) {
                $number = $matches[0];

                 $sortedArray[$number][$key] = $value;
                
            }
        }

        return $sortedArray;
    }

    /**
     * 
     * Sort the answers
     * 
     *  Question 1
     *  |----------Question
     *  |           |-------Type
     *  |           |-------Id
     *  |           |-------body
     *  |
     *  |-----------Answers
     *              |-------Answer
     *              |       |-------id
     *              |       |-------body
     *              |
     *              |-------Answer
     *              |       |-------id
     *              |       |-------body
     *              |       |-------is_correct
     *           
     */
    public static function buildQuestionsToShow($fullExamData) {
        $sortedQuestions = [];
        
        foreach ($fullExamData as $answerDetails) {
            
            if (empty($sortedQuestions) || $sortedQuestions[array_key_last($sortedQuestions)]->id != $answerDetails->question_id) {

                $newQuestion = new Question();
                $newAnswer = new Answer();

                $newQuestion->number = count($sortedQuestions) + 1;
                $newQuestion->id = $answerDetails->question_id;
                $newQuestion->type = $answerDetails->type;
                $newQuestion->body = $answerDetails->question_body;
                $newQuestion->picture_url = $answerDetails->picture_url;
                
                $newAnswer->id = $answerDetails->answer_id;
                $newAnswer->body = $answerDetails->answer_body;
                $newAnswer->is_correct = $answerDetails->is_correct;
                
                $newQuestion->answers[] = $newAnswer;
                $sortedQuestions[] = $newQuestion;
                
            } else {

                $latestQuestion = $sortedQuestions[array_key_last($sortedQuestions)];

                $newAnswer = new Answer();

                $newAnswer->id = $answerDetails->answer_id;
                $newAnswer->body = $answerDetails->answer_body;
                $newAnswer->is_correct = $answerDetails->is_correct;
                
                $latestQuestion->answers[] = $newAnswer;

            } 
        }


        return $sortedQuestions; 
    }

    /**
     * Arrange answer submited from exam
     */
    public static function submittedAnswers($submittedArray) {

        $sortedArray = [];

        foreach($submittedArray as $key => $value) {
            if (str_contains($key, "q")) 
                $sortedArray[$key] = $value;
        }

        return $sortedArray;
    }

    /**
     * This function is specific for editing exam questions
     * 
     * It sorts answers submitted, such that each three item in array represents [id, body, is_correct] of each answer
     */

    public static function makeAnswersFromArray (array $answerArray ) {
        $correctAnswerIndex = 0;
        $plainArray = array_values($answerArray);

        $sortedAnswer = [];

        if (count($plainArray) == 2) { // True or false option
            
            $sortedAnswer = [...$plainArray];
            
            $sortedAnswer[] = 1;  // is_correct option
            
        } else { // for A-D or A-E options


            // First get which option is correct, get its index
            foreach($answerArray as $key => $value) {

                if (str_contains($key, "correct_answer")) break;
                
                $correctAnswerIndex++;
            }

            // Remove the correct answer option from array
            array_splice($plainArray, $correctAnswerIndex, 1); // unset() also works            

            // Sort answers
            for ($i = 0; $i < count($plainArray); $i += 2) {

                $sortedAnswer[] = $plainArray[$i];  // id
                $sortedAnswer[] = $plainArray[$i + 1];  // body
                $sortedAnswer[] = 0;    // is_correct

            }

            // Change the is_correct bool to true for the right answer - magic numbers comes from keen observation lol
            $sortedAnswer[($correctAnswerIndex / 2 ) * 3 - 1] = 1;            
        }

        return $sortedAnswer;
    }
}