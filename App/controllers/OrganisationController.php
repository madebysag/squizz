<?php

namespace App\Controllers;

use Framework\Database;

use App\Models\Organisation;
use Framework\Validator;

class OrganisationController {

    protected $db;

    protected $organisationModel;

    public function __construct() {

        $config = require basePath("config/db.php");
        $this->db = new Database($config);

        $this->organisationModel = new Organisation($this->db);
    }

    /**
     * Show create form
     * 
     */
    public function create () : void {

        loadView("users/organisations/create");
    }


    public function store () : void {

        $error = [];

        if (!Validator::string($_POST["name"], 2, 100))    
            $error["name"] = "Name should be 2 to 100 characters";
        
        if (!Validator::email($_POST["email"]))    
            $error["email"] = "Enter a valid email";

        if (!Validator::string($_POST["address"], 2, 255))    
            $error["address"] = "Address should be 2 to 255 characters";
        
        if (!Validator::password($_POST["password"]))    
            $error["password"] = "Password too short!";

        if (!Validator::match($_POST["password"], $_POST["password2"]))    
            $error["password2"] = "Passwords does not match";


        if(!empty($error)) {
            loadView("users/organisations/create", [
                "error" => $error,
                "user" => [
                    "name" => $_POST["name"],
                    "email" => $_POST["email"],
                    "address" => $_POST["address"],
                ]
            ]);
            
            return;
        }

        // Save to datwabase
        $params = [
            "name" => $_POST["name"],
            "email" => $_POST["email"],
            "address" => $_POST["address"],
            "password" => password_hash($_POST["password"], PASSWORD_DEFAULT),
        ];

        $this->organisationModel->save($params);

        $newOrganisationId = $this->organisationModel->lastInsertId();

        redirect("/");

        exit;
    }
}