<?php

namespace Framework;

/**
 * Sort and arrange questions or answers data
 */

class Sorter {
    public static function sort(array $dataArray, string $pattern = "/\d+/") {

        $sortedArray = [];  

        foreach($dataArray as $key => $value) {
            if (preg_match($pattern, $key, $matches)) {
                $number = $matches[0];

                 $sortedArray[$number][$key] = $value;
                
            }
        }

        return $sortedArray;
    }
}