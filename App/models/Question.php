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

        inspect($params, false);
        inspect($queryValuesString);
        
        $this->db->query("INSERT INTO `questions` (type, body, picture_url, exam_id) VALUES {$queryValuesString}", $params, false);
    }

}