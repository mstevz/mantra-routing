<?php
namespace Mantra\Routing;

use \ReflectionClass;
use Mantra\Routing\Attributes\{Route, Get, Post, Put, Delete};

class Router {

    private string $baseUri = '';

    private array $routes = [];

    public function __construct(){ }

    public function setBaseUri(string $value) : void {
        $this->baseUri = $value;
    }

    public function dispatch(string $method, string $uri, array $params){

        // handle middleware here

        foreach($this->routes[strtolower($method)] as $pattern => $controllerMeta){

            $matches;
            if(preg_match_all($pattern , $uri, $matches, \PREG_PATTERN_ORDER)){

                $handler = explode('@', $controllerMeta['handler']);
        
                $controller = array_shift($handler);
                $method = array_pop($handler);
                
                $ref = new \ReflectionMethod($controller, $method);
                
                array_shift($matches);

                for($i = 0; $i < count($matches); $i++){
                    $matches[$i] = $matches[$i][0];
                }

                if(count($matches) == $controllerMeta['numArgs']){

                    for($i = 0; $i < $controllerMeta['numArgs']; $i++){
                        
                        switch($controllerMeta['argTypes'][$i]){
                            case 'int':
                                $matches[$i] = strval($matches[$i]);
                        }

                    }
                    
                }

                return $ref->invokeArgs(new $controller, $matches);
            }

        }

    }
    
    public function buildRouter($controllers){

        $routeHandlers = array();
    
        foreach($controllers as $controller){
            $routes = $this->getControllerRoutes($controller);
    
            foreach($routes as $method => $patterns){
    
                if(array_key_exists($method, $routeHandlers)) {
                    foreach($patterns as $pattern => $handler) {
                        
                        if(array_key_exists($pattern, $routeHandlers[$method])){
                            error_log("[WARNING]: [{$method} {$pattern}] Handler Overwriten!");
                        }
                        
                        $routeHandlers[$method][$pattern] = $handler;
                        
                    }
                }
                else {
                    $routeHandlers[$method] = $patterns;
                }
    
            }
    
        }
        
        $this->routes = $routeHandlers;
    }

    public function getRoutes() : array {
        return $this->routes;
    }

    private function getControllerRoutes($controller){
    
        $reflect = new ReflectionClass($controller);
    
        $objPath = $reflect->getName();
        $controller = new $objPath;
        
        $router = [];
    
        foreach($reflect->getMethods() as $method){

            $router = $this->buildControllerMetadata($objPath, $method, $router, Route::class);
            $router = $this->buildControllerMetadata($objPath, $method, $router, Get::class);
            $router = $this->buildControllerMetadata($objPath, $method, $router, Put::class);
            $router = $this->buildControllerMetadata($objPath, $method, $router, Post::class);
            $router = $this->buildControllerMetadata($objPath, $method, $router, Delete::class);
        }
        
        return $router;
    }

    private function buildControllerMetadata($objPath, $method, $router, string $class) : array {
        foreach($method->getAttributes($class) as $attr){
            $route = $attr->newInstance();

            $params = $method->getParameters();
            $paramsType = [];

            foreach($params as $param){

                $type = $param->getType();

                $paramsType[] .= ($type) ? $type->getName() : 'dynamic';
            }

            $pattern = $this->baseUri . $route->getUrlPattern();

            $router[$route->getVerb()][$pattern] = [
                'handler'  => $objPath . '@' . $method->name,
                'numArgs'  => $method->getNumberOfRequiredParameters(),
                'argTypes' => $paramsType
            ];
        }

        return $router;
    }

}
?>