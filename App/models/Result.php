<?php

namespace App\Models;

use App\Models\Base\Model;

class Result extends Model {

    protected string $tableName = "results";

    public function update(array $params) {
        
        $this->db->query("UPDATE `results` SET score = :score, correct = :correct, wrong = :wrong, updated_at = CURRENT_TIMESTAMP WHERE id = :id;", $params);
    }

    public function save(array $params) {
        
        $this->db->query("INSERT INTO `results` (exam_id, student_id, score, correct, wrong) VALUES (:exam_id, :student_id, :score, :correct, :wrong);", $params);
    }

    /**
     * Latest Student Result 
     */
    public function studentResult(int $student_id) : ?object {
        
        return $this->db->query("SELECT * FROM `results` WHERE student_id = :student_id ORDER BY created_at DESC LIMIT 1;", ["student_id" => $student_id])->fetch();
    }
        
    public function tutorResults(int $exam_id, int $limit = 10) : ?array {
        
        // return $this->findMany($exam_id, "exam_id", $limit);
        return $this->db->query("SELECT DISTINCT r.score, r.correct, r.wrong, r.updated_at, u.name FROM `results` r INNER JOIN `users` u ON r.student_id = u.id WHERE r.exam_id = :exam_id ORDER BY r.updated_at DESC LIMIT {$limit}", ["exam_id" => $exam_id])->fetchAll();
    }
}