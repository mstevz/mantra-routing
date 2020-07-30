<?php

namespace Mantra\Routing;

use Mantra\Routing\Interfaces\IRouter;
use Mantra\Routing\RouteIdentifier;
use Mantra\Routing\Exceptions\RouteNotFoundException;
use Mantra\Routing\Http\Environment;
use Mantra\Routing\Route;

use Psr\Http\Message\RequestInterface as IRequest;

class Dispatcher {

    /**
     * References the router.
     * @var IRouter
     */
    private $router;

    public function __construct(IRouter $router){
        $this->router = $router;
    }

    /**
     * Attempts to match requested Uri string with available routes.
     * @param  $routes [description]
     * @param  $candidateUri [Requested Uri string]
     * @return null|Route
     */
    private function findRoute(object $routes, string $candidateUri) : ?Route {
        $result = null;

        foreach($routes as $route) {
            $matches = [];
            $pattern = $route->getPattern();

            preg_match("#^($pattern)$#", $candidateUri, $matches);

            if($matches){
                $result = $route;
                break;
            }
        }

        return $result;
    }

    public function dispatch(IRequest $request) : Route {
        $routes = $this->router->getRoutes()[$request->getMethod()];

        $route = $this->findRoute($routes, $request->getUri()->getPath());

        try{
            if(!$route){
                http_response_code(404);  // define header elsewhere!
                throw new RouteNotFoundException($request->getUri()->getPath());
            }
        }
        catch(\Exception $e){
            echo $e->getMessage();
            exit;
        }

        return $route;

    }

}

?>
