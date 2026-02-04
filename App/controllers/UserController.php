<?php

namespace App\Controllers;

use Framework\Database;

use App\Models\User;
use Framework\Validator;

class UserController {

    protected $db;

    protected $userModel;

    public function __construct() {

        $config = require basePath("config/db.php");
        $this->db = new Database($config);

        $this->userModel = new User($this->db);
    }

    /**
     * Show create form
     * 
     */
    public function create () : void {

        loadView("users/create");
    }


    public function store () : void {

        $error = [];

        if (!Validator::name($_POST["name"]))    
            $error["name"] = "Firstname and lastname should be 2 to 55 characters";
        
        if (!Validator::email($_POST["email"]))    
            $error["email"] = "Enter a valid email";
        
        if (!Validator::password($_POST["password"]))    
            $error["password"] = "Password too short!";

        if (!Validator::match($_POST["password"], $_POST["password2"]))    
            $error["password2"] = "Passwords does not match";


        if(!empty($error)) {
            loadView("users/create", [
                "error" => $error,
                "user" => [
                    "name" => $_POST["name"],
                    "email" => $_POST["email"],
                ]
            ]);
            
            return;
        }

        // Save to datwabase
        $params = [
            "name" => $_POST["name"],
            "email" => $_POST["email"],
            "role" => $_POST["role"],
            "password" => password_hash($_POST["password"], PASSWORD_DEFAULT),
            "organisation_id" => 1 # Get this from session when user authenticates
        ];

       inspect($this->userModel->find(1));
        $this->userModel->save($params);

        $newUserId = $this->userModel->lastInsertId();

        redirect("/");

        exit;
    }
}