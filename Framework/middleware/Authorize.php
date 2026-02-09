<?php

namespace Framework\Middleware;

use Framework\Session;

class Authorize {

    /**
     * Check who is logged in
     * 
     * Check if the loged in user role is "student" and "tutor" or organisation admin
     * 
     * Schema
     *          User
     *            |----student
     *            |----tutor
     *          ---------------
     *          Admin
     * 
     */
    public static function isAuthenticated($userType = "user", $role = "student") : bool {

        // if (isset(Session::get($userType))) {

        // }
        // inspect(Session::has($userType));

        if (Session::has($userType)) {

            if ($userType == "user") {
                return Session::get($userType)["role"] === $role;
            }
    
            return Session::has($userType);

        } else {
            return false;
        }

    }

    /**
     * List of middlewares:
     *  - "guest": Not signed
     *  - "student": signed in as student or teacher only
     *  - "tutor": signed in as teacher only
     *  - "org": signed in as admin only
     */
    public static function handle(string $role) : void {

        if($role === "guest" && (self::isAuthenticated("user", "student") || self::isAuthenticated("user", "tutor") || self::isAuthenticated("admin"))) {

            redirect("/");

        } elseif ($role === "student" && !self::isAuthenticated("user", "student")) {
            
            redirect("/auth/users/login");
            
        } elseif ($role === "tutor" && !self::isAuthenticated("user", "tutor")) {

            redirect("/auth/users/login");
            
        } elseif ($role === "org" && !self::isAuthenticated("admin")) {

            redirect("/auth/organisations/login");

        }
    }
}