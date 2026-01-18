<?php

namespace App\Controllers;

class ErrorController {

    public static function notFound(string $message = "This page does not exists!") : void {

        // loadView("error", [
        //     "status" => 404,
        //     "message" => $message
        // ]);
        inspect($message);
    }
}