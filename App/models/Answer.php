<?php

namespace App\Models;

use App\Models\Base\Model;
use Framework\Sorter;

class Answer extends Model{

    protected string $tableName = "answers";


    public function findByQuestion(string $questionId) {

        $params = [
            "question_id" => $questionId
        ];

        return $this->db->query("SELECT * FROM `answers` WHERE `question_id` = :question_id; ", $params)->fetch();
    }
    
    public function save(array $params) : void {
        
        $this->db->query("INSERT INTO `answers` (body, question_id) VALUES (:body, :question_id)", $params);
    }

    public function saveMany(array $answerArray, int $firstQuestionId) : void {

        $queryValuesString = "";
        $params = [];

        $currentQuestionId = $firstQuestionId;


        foreach($answerArray as $questionNumber => $answers) {

            foreach($answers as $option => $body) {

                // Catch Correct answers for A-D and A-E
                if (str_contains($option, "correct_answer") && count($answers) != 1) {

                    // Roll back to change the is_correct column value for the previous iteration, if it is not the first iteration.
                    if (isset($params[count($params) - 3])) $params[count($params) - 3] = 1;
                    else $params[] = 1;

                    continue;

                } else if(count($answers) == 1) { // Handle setting correct answer for true or false questions
                    $params[] = 1;
                    $params[] = $currentQuestionId;
                    $params[] = $body;
                } else { // Hanlde non correct answers
                    $params[] = 0;
                    $params[] = $currentQuestionId;
                    $params[] = $body;
                }

                // Add (? , ?) to query string
                $queryValuesString .= "(?, ?, ?),";
                
            }

            // Increment the ID after each question
            $currentQuestionId++;
        }

        $queryValuesString = trim($queryValuesString, ",");
        
        $this->db->query("INSERT INTO `answers` (is_correct, question_id, body) VALUES {$queryValuesString}", $params, false);
    }

    public function findManyAnswers(array $ids, $buffer) : array {
        $queryValuesString = "";
        $params = [];

        foreach($ids as $key => $value) {
            $value = $value - $buffer;

            if ($value == "0") // Means a fabricated option
                continue;
            
            $params[] = $value;
            $queryValuesString .= "?,";
        }

        $queryValuesString = trim($queryValuesString, ",");

        return $this->db->query("SELECT * FROM `answers` WHERE id IN ({$queryValuesString});", $params, false)->fetchAll();
    }

    public function updateMany($answersArray) : void{

        $params = [];

        foreach($answersArray as $questionNumber => $answers) {

            $sortedAnswers = Sorter::makeAnswersFromArray($answers);

            $params = [...$params, ...$sortedAnswers];
            
        }

        
        $queryValuesString = str_repeat("ROW(?, ?, ?),", count($params) / 3);
        
        $queryValuesString = trim($queryValuesString, ",");
        

        $this->db->query("UPDATE `answers` JOIN( VALUES {$queryValuesString}) AS NEW(id, body, is_correct) ON answers.id = NEW.id SET answers.body = NEW.body, answers.is_correct = NEW.is_correct;", $params, false);
    }

}