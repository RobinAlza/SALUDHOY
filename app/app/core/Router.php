<?php
class Router {
    public function dispatch($url) {
        $url = strtolower(trim($url, '/'));
        
        $routes = [
            ''          => ['controller' => 'HomeController', 'method' => 'index'],
            'index'     => ['controller' => 'HomeController', 'method' => 'index'],
            'about'     => ['controller' => 'PageController', 'method' => ' '],
            'contact'   => ['controller' => 'PageController', 'method' => 'contact'],
        ];
        
        if (isset($routes[$url])) {
            $controllerName = $routes[$url]['controller'];
            $methodName = $routes[$url]['method'];
            
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $methodName)) {
                    $controller->$methodName();
                    return;
                }
            }
        }
        
        // Mostrar error 404
        header("HTTP/1.0 404 Not Found");
        include __DIR__.'/../../views/errors/404.php';
        exit;
    }
    private function show404() {
        header("HTTP/1.0 404 Not Found");
        echo "Página no encontrada";
        exit;
    }
}