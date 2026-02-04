<?php

namespace Framework;

class Validator {


    public static function string(string $value, int $min = 2, int $max = 55) : bool {
        $value = trim($value);
        $length = strlen($value);

        return $length >= $min && $length <= $max;
    }

    public static function email(string $email) : bool {
        $email = trim($email, " ");
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function match(string $value, string $value2) : bool {
        $value = trim($value);
        $value2 = trim($value2);

        return $value == $value2;
    }

    public static function name(string $name, int $min = 2, int $max = 55) : bool {
        $name = trim($name);
        
        if (empty($name)) return false;

        $nameArray = explode(" ", $name);
        
        if (count($nameArray) != 2) return false;

        foreach($nameArray as $value) {
            if (!self::string($value, $min, $max)) return false;
        }

        return true;
    }
    
    public static function password(string $password) : bool {
        if (!self::string($password, 8)) return false;

        return true;
    }
}