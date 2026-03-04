<?php

declare(strict_types=1);

/**
 * Return base Path
 * 
 * @param string $path;
 * 
 * @return string; 
 */
function basePath($path) {
    return __DIR__ . "/" . $path;
}

/**
 * inspect and die?
 * 
 * @param any $variable;
 * 
 * @return void; 
 */
function inspect($variable, $die = true) {
    if ($die) {
        echo "<pre> die";
        die(var_dump($variable));
        echo "</pre>";
    } else {
        echo "<pre>";
        var_dump($variable);
        echo "</pre>";
    }
}

/**
 * Load View
 * 
 * @param string $name;
 * @param array $data;
 * 
 * @return void; 
 */
function loadView(string $name, array $data = []) {

    $viewPath = basePath("App/views/{$name}.view.php");

    if (file_exists((string) $viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "File does not exist. Fullpath = {$viewPath}";
    }
}

/**
 * Load Partial from the partial folder
 * 
 * @param string $name;
 * @param array $data;
 * 
 * @return void; 
 */
function loadPartial(string $name, array $data = []) {

    $partialPath = basePath("App/views/partials/{$name}.php");

    if (file_exists((string) $partialPath)) {
        extract($data);
        require $partialPath;
    } else {
        echo "Partial File does not exist. Fullpath = {$partialPath}";
    }
}


/**
 * Redirect to a url
 * 
 * @param string $url;
 * 
 * @return void; 
 */
function redirect(string $url) {
    header("Location: {$url}");
}

/**
 * Sanitize input from malicious scripts
 * 
 * @param string $value
 * 
 * @return string;
 */
function sanitize($value) {
    return filter_var(trim($value), FILTER_SANITIZE_SPECIAL_CHARS);
}

/**
 * Format Date coming from Database 
 * 
 * @param string $date;
 * @param string $delimiter;
 * 
 * @return string; 
 */
function formatDate(string $date, string $delimiter = "—") {
    try {
        $dateObject = new DateTime($date);

        $formatedDate =  $dateObject->format("F d, Y - h:i a");
        $formatedDate = explode("-", $formatedDate);

        return implode($delimiter, $formatedDate);
        
    } catch (Exception $e) {
        throw new Exception("Failed to parse date from DB: {$e->getMessage()}"); 
    }  
}

/**
 * Check if exam is live 
 * 
 * @param string $start_at;
 * @param string $end_at;
 * 
 * @return bool; 
 */
function isExamLive(string $start_at, string $end_at) {
    $start = strtotime($start_at);
    $end = strtotime($end_at);

    return ($start <= time()) && ($end >= time());
}