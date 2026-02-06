<?php

namespace App\Models;

use App\Models\Base\Model;

class Exam extends Model{
    protected string $tableName = "exams";

    
    public function save(array $params) {
        
        return $this->db->query("INSERT INTO `exams` (title, author_id, course, tags, duration, start_at, end_at, instructions, questions_count, exam_key) VALUES (:title, :author_id, :course, :tags, :duration, :start_at, :end_at, :instructions, :questions_count, :exam_key); SELECT LAST_INSERT_ID();", $params);
    }


}