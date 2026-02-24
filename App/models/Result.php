<?php

namespace App\Models;

use App\Models\Base\Model;

class Result extends Model {

    protected string $tableName = "results";

    public function update(array $params) {
        
        $this->db->query("UPDATE `results` SET (score = :score, correct = :correct, wrong = :wrong, updated_at = CURRENT_TIMESTAMP) WHERE id = :id;", $params);
    }

    public function save(array $params) {
        
        $this->db->query("INSERT INTO `results` (exam_id, student_id, score, correct, wrong) VALUES (:exam_id, :student_id, :score, :correct, :wrong);", $params);
    }

}