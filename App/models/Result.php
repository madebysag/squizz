<?php

namespace App\Models;

use App\Models\Base\Model;

class Result extends Model {

    protected string $tableName = "results";

    public function saveMany(array $questionArray, int $examId) {
        
        $params = []; 

        $queryValuesString = "";

        $this->db->query("INSERT INTO `questions` (type, body, picture_url, exam_id) VALUES {$queryValuesString}", $params, false);
    }

    public function update($value, $columnName = "id") {
        
        return $this->db->query("SELECT * FROM `{$this->tableName}` WHERE {$columnName} = :{$columnName};", [ "{$columnName}" => $value]);
    }

}