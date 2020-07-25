<?php

namespace Mantra\Routing;

use Mantra\Routing\Interfaces\IRouter;
use Mantra\Routing\RouteIdentifier;
use Mantra\Routing\Exceptions\RouteNotFoundException;

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
     * Returns an Annonymous Function that will be used as callback to find route.
     * @param  $request [description]
     * @return [type]   [description]
     */
    private function findRouteCallback($request) {
        return function($id, $route) use ($request){
            return (RouteIdentifier::getIdentityFromUri($request) == $route->getIdentity());
        };
    }

    public function dispatch($request){

        var_dump($request);
        $route = $this->router->find($this->findRouteCallback($request));


        try{
            if(!$route) throw new RouteNotFoundException($request);

            $route();
        }
        catch(\Exception $e){
            // not found
            //echo "<h1>404</h1> <h2>Details</h2> <b>Requested</b>: {$e->getMessage()} </br> <b>Status Code</b>: 404 </br> <b>Status Message</b>: Not Found.";
            echo $e->getMessage();
        }

    }

}

?>
