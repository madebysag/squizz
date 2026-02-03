<?php

namespace App\Models;

use App\Models\Base\Model;

class Answer extends Model{

    public function findByQuestion(string $questionId) {

        $params = [
            "question_id" => $questionId
        ];

        return $this->db->query("SELECT * FROM `answers` WHERE `question_id` = :question_id; ", $params)->fetch();
    }
    
    public function save(array $params) {
        
        $this->db->query("INSERT INTO `answers` (body, question_id) VALUES (:body, :question_id)", $params);
    }

    public function saveMany(array $answerArray) {

        $queryValuesString = "";
        $params = [];

        foreach($answerArray as $questionId => $answers) {

            foreach($answers as $option => $body) {

                // Catch Correct answers for A-D and A-E
                if (str_contains($option, "correct_answer") && count($answers) != 1) {

                    // Roll back to change the is_correct column value for the previous iteration, if it is not the first iteration.
                    if (isset($params[count($params) - 3])) $params[count($params) - 3] = 1;
                    else $params[] = 1;

                    continue;

                } else if(count($answers) == 1) { // Handle setting correct answer for true or false questions
                    $params[] = 1;
                    $params[] = $questionId;
                    $params[] = $body;
                } else { // Hanlde non correct answers
                    $params[] = 0;
                    $params[] = $questionId;
                    $params[] = $body;
                }

                // Add (? , ?) to query string
                $queryValuesString .= "(?, ?, ?),";

            }
        }

        $queryValuesString = trim($queryValuesString, ",");
        // inspect($queryValuesString, false);
        // inspect($params, false);
        
        $this->db->query("INSERT INTO `answers` (is_correct, question_id, body) VALUES {$queryValuesString}", $params, false);
    }

}