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
     * @param  iterable $routes Iterable container with objects of type 'Route'.
     * @param  string   $path   Requested Uri path.
     * @return null|Route        [description]
     */
    private function match(iterable $routes, string $path) : ?Route {
        $route = null;

        foreach($routes as $candidate) {
            $matches = [];
            $pattern = $candidate->getPattern();

            preg_match("#^($pattern)$#", $path, $matches);

            if($matches){
                $route = $candidate;
                break;
            }
        }

        return $route;
    }

    public function dispatch(IRequest $request) : Route {
        $method = $request->getMethod();
        $path   = $request->getUri()->getPath();

        $possibleRoutes = $this->router->getRoutes($method);
        $route          = $this->match($possibleRoutes, $path);

        try{
            if(!$route){
                http_response_code(404);  // define header elsewhere!
                throw new RouteNotFoundException($path);
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
