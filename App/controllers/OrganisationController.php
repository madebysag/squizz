<?php

namespace App\Controllers;

use Framework\Database;

use App\Models\Organisation;
use Framework\Validator;
use Framework\Session;

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

        Session::set("admin", [
            "id" => $newOrganisationId,
            "name" => $params["name"],
            "email" => $params["email"],
            "address" => $params["address"]
        ]);

        redirect("/");

        exit;
    }
    
    /**
     * Log in both Student and Tutor
     */
    public function login() : void {

        loadView("users/organisations/login");
    }

    /**
     * Log in both Student and Tutor
     */
    public function authenticate() {

        $error = [];
        
        if (!Validator::email($_POST["email"]))    
            $error["email"] = "Please enter a valid email!";
        
        if (!Validator::password($_POST["password"]))    
            $error["password"] = "Password too short!";


        if(!empty($error)) {
            loadView("users/organisations/login", [
                "error" => $error,
                "user" => [
                    "email" => $_POST["email"],
                ]
            ]);
            
            return;
        }

        // Check user in database
        $email = $_POST["email"];
        $password = $_POST["password"];

        $admin = $this->organisationModel->find($email, "email");

        // No User found
        if(!$admin) {

            $error["password"] = "Invalid Credentials";

            loadView("users/organisations/login", [
                "error" => $error,
                "user" => [
                    "email" => $email,
                ]
            ]);
            
            return;
        }

        // Wrong password
        if(!password_verify($password, $admin->password)) {

            $error["password"] = "Invalid Credentials";

            loadView("users/organisations/login", [
                "error" => $error,
                "user" => [
                    "email" => $email,
                ]
            ]);
            
            return;
        }

        Session::set("admin", [
            "id" => $admin->id,
            "name" => $admin->name,
            "email" => $admin->email,
            "address" => $admin->address
        ]);

        redirect("/");

        exit;
    }

    public function logout() {

        Session::clearAll();

        $params = session_get_cookie_params();

        setcookie("PHPSESSID", "", time() - 86400, $params["path"], $params["domain"]);

        redirect("/");
    }
}