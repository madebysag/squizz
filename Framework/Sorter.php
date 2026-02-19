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
}