<?php

namespace App\Models;

use App\Models\Base\Model;

class Question extends Model {

    protected string $tableName = "questions";

    public function saveMany(array $questionArray, int $examId) {

        $queryValuesString = "";
        $params = [];

        foreach($questionArray as $questionNumber => $question) {
                
            $queryValuesString .= "(?, ?, ?, ?),";

            $params = [...$params, ...$question];
            $params[] = $examId;
        }
        
        $params = array_values($params); 

        $queryValuesString = trim($queryValuesString, ",");

        $this->db->query("INSERT INTO `questions` (type, body, picture_url, exam_id) VALUES {$queryValuesString}", $params, false);
    }

    /**
     * 
     * Strong contender in INSERT INTO ... ON DUPLICATE KEY UPDATE
     * 
     * On a second thought.... editing should be purely changing texts and correct answers, not adding nor deleting questions
     *
     * The query we are aiming for 
        UPDATE questions JOIN (VALUES ROW(1, "This boddyyyy", "hhhh"), ROW(2, "WHo might this beeee", "URLLLLS") ) AS new(id, body, picture_url) ON questions.id = new.id SET questions.body = new.body, questions.picture_url = new.picture_url;


        UPDATE
            questions
        JOIN(
            VALUES ROW(1, "This boddyyyy", "hhhh"),
            ROW(
                2,
                "WHo might this beeee",
                "URLLLLS"
            )
        ) AS NEW(id, body, picture_url)
        ON
            questions.id = NEW.id
        SET
            questions.body = NEW.body,
            questions.picture_url = NEW.picture_url;
            
    */
    public function updateMany(array $questionArray) {

        $queryValuesString = "";
        $params = [];

        foreach($questionArray as $questionNumber => $question) {
                
            $queryValuesString .= "ROW(?, ?, ?, ?),";

            $params = [...$params, ...$question];
        }
        
        $params = array_values($params); 

        $queryValuesString = trim($queryValuesString, ",");


        $this->db->query("UPDATE `questions` JOIN( VALUES {$queryValuesString}) AS NEW(id, type, body, picture_url) ON questions.id = NEW.id SET questions.body = NEW.body, questions.picture_url = NEW.picture_url;", $params, false);
    }

}