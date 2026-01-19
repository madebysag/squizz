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

    if (file_exists($viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "File does not exist. Fullpath = {$viewPath}";
    }
}