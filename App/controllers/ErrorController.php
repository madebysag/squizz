<?php

namespace App\Controllers;

class ErrorController {

    public static function notFound(string $message = "This page does not exists!") : void {

        loadView("error/404", [
            "status" => 404,
            "message" => $message
        ]);
    }

    public static function forbiddden(string $message = "You are unauthorized to access this page!!") : void {

        loadView("error/404", [
            "status" => 403,
            "message" => $message
        ]);
    }
}