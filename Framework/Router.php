<?php

namespace Framework;

use Framework\Middleware\Authorize;
use App\Controllers\ErrorController;

class Router {
    protected array $routes = [];

    public function register(
        string $method, 
        string $uri,
        string $action,
        array $middleware
        ): void {

            [$controller, $controllerMethod] = explode("@", $action);

            $this->routes[] = [
                "uri" => $uri,
                "method" => $method,
                "controller" => $controller,
                "controllerMethod" => $controllerMethod,
                "middleware" => $middleware
            ];
    }
  
    public function get(string $uri, string $action, array $middleware = []): void {

        $this->register("GET", $uri, $action, $middleware);
    }
  
    public function post(string $uri, string $action, array $middleware = []): void {

        $this->register("POST", $uri, $action, $middleware);
    }
  
    public function put(string $uri, string $action, array $middleware = []): void {

        $this->register("PUT", $uri, $action, $middleware);
    }
  
    public function delete(string $uri, string $action, array $middleware = []): void {

        $this->register("DELETE", $uri, $action, $middleware);
    }

    public function route(string $uri) : void {

        $requestMethod = $_SERVER["REQUEST_METHOD"];

        $requestSegments = explode("/", trim($uri, "/"));
        
        foreach($this->routes as $route) {

            $routeSegments = explode("/", trim($route["uri"], "/"));
            
            $match = true;
            
            // Check if the number of request/routes segements length and methods are similar 
            if (count($routeSegments) == count($requestSegments) && strtoupper($requestMethod) == $route["method"]) {

                $params = [];

                $match = true;

                for ($i=0; $i < count($requestSegments); $i++) { 
                    
                    // if the two segments are the not same and the current route segment is not matched with regex {(.+?)} i.e not in curly braces
                    if ($requestSegments[$i] !== $routeSegments[$i] && !preg_match("/\{(.+?)\}/", $routeSegments[$i]) ) {
                        $match = false;
                        break;
                    }
                    
                    if (preg_match("/\{(.+?)\}/", $routeSegments[$i], $matchs)) {
                        $params[$matchs[1]] = $requestSegments[$i]; 
                        // inspect($params, false);
                    }
                }

                if ($match) {

                    foreach($route["middleware"] as $middleware) {
                        Authorize::handle($middleware);
                    }

                    $controller = "App\\Controllers\\" . $route["controller"];
                    $controllerMethod =  $route["controllerMethod"];

                    $controllerInstance = new $controller;
                    $controllerInstance->$controllerMethod($params);
                    return;
                }
            }
        }

        ErrorController::notFound();
    }
}