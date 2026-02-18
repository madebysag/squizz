<?php

$router->get("/", "HomeController@index");  //  List all Public exams #

$router->get("/exams/write", "ExamController@index", ["student"]); //  Where exam key is entered to take exam  #
$router->get("/exams/create", "ExamController@create", ["tutor"]); //  show Form where new exams are uploaded # 
$router->get("/exams/list", "ExamController@list", ["tutor"]); //  Show all exams uploaded by tutor # 

$router->get("/exams/{key}/start", "ExamController@start", ["student"]); //  Start an exam # 

$router->post("/exams/write", "ExamController@checkKey", ["student"]); //  Where exam key is entered to take exam #

$router->post("/exams", "ExamController@store", ["tutor"]);  // Upload a new exam

$router->get("/exams/results", "ResultController@showAll", ["user"]); //  Show results for all exam taken by student #
$router->get("/exams/results/{key}", "ResultController@show", ["student"]); //  Show results for a particular exam taken by student #

$router->put("/exams/results/{key}", "ResultController@update", ["student"]); //  Show results for a particular exam taken by student #

$router->post("/exams/results/{key}", "ResultController@store", ["student"]); //  where reuslts are upload #

$router->get("auth/users/register", "UserController@create", ["org"]); //  show Form where new user(student / tutor) or tutor are created # 
$router->get("auth/users/login", "UserController@login", ["guest"]); //  show user(student / tutor) Login form # 

$router->post("auth/users/register", "UserController@store", ["org"]);  
$router->post("auth/users/login", "UserController@authenticate", ["guest"]);  
$router->post("auth/users/logout", "UserController@logout", ["user"]);  


$router->get("auth/organisations/register", "OrganisationController@create", ["guest"]);  
$router->get("auth/organisations/login", "OrganisationController@login", ["guest"]);  

$router->post("auth/organisations/register", "OrganisationController@store", ["guest"]); 
$router->post("auth/organisations/login", "OrganisationController@authenticate", ["guest"]); 
$router->post("auth/organisations/logout", "OrganisationController@logout", ["org"]); 



// $router->post("/auth/exams/write", "ExamController@getExam"); // Get exam

$router->put("/exams/{id}/edit", "ExamController@edit");   // edit an exam
$router->delete("/exams/{id}", "ExamController@delete");   // Delete an uploaded exam

$router->post("/exams/{id}/start", "ExamController@start");  // Start an exam
$router->post("/exams/{id}/submit", "ExamController@submit"); // submit an exam
$router->get("/exams/{id}/finish", "ExamController@finish"); // Get the finish page which may have result displayed

$router->get("/tutors/{name}/exams", "TutorController@exams"); // show all exams by the tutor


// $router->get("/students/{id}", "HomeController@create");