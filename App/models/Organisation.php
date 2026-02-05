<?php

namespace App\Models;

use App\Models\Base\Model;

class Organisation extends Model{
    protected string $tableName = "organisations";
    
    public function save(array $params) {
        
        $this->db->query("INSERT INTO `organisations` (name, email, password, address) VALUES (:name, :email, :password, :address);", $params);
    }


}