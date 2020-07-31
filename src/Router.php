<?php

namespace Mantra\Routing;

use Mantra\Routing\Interfaces\IRouter;
use Mantra\Routing\RouteResolver;
use mstevz\collection\{Dictionary, ArrayList};

class Router implements IRouter {

    /**
     * Application Route Collection
     * @see mstevz\Collection
     * @var Collection
     */
    private $routes;

    public function __construct(){
        $this->routes = new Dictionary();

        $this->addVerb('GET');
        $this->addVerb('POST');
        $this->addVerb('PUT');
        $this->addVerb('DELETE');
    }

    private function addVerb(string $verb){
        $this->routes->add($verb, new ArrayList('object'));
    }

    /**
     * Maps any kind of Route with specified urlPattern to specific operation handler.
     * @param  string $method      Http Verb
     * @param  string $urlPattern  Router link pattern
     * @param  [type] $handler     Route operation handler
     * @return [type]             [description]
     */
    public function map(string $method, string $urlPattern, $handler){
        $route = new Route($method, $urlPattern, new RouteResolver($handler));

        $this->routes->get($method)
                      ->add($route);
    }

    /**
     * Creates a new GET rest request Route.
     * @param  string $urlPattern  Router link pattern
     * @param  [type] $handler     Route operation handler
     * @return [type]             [description]
     */
    public function get(string $urlPattern, $handler){
        $this->map('GET', $urlPattern, $handler);
    }

    /**
     * Creates a new POST rest request Route.
     * @param  string $urlPattern  Router link pattern
     * @param  [type] $handler     Route operation handler
     * @return [type]             [description]
     */
    public function post(string $urlPattern, $handler){
        $this->map('POST', $urlPattern, $handler);
    }

    /**
     * Creates a new PUT rest request Route.
     * @param  string $urlPattern  Router link pattern
     * @param  [type] $handler     Route operation handler
     * @return [type]             [description]
     */
    public function put(string $urlPattern, $handler){
        $this->map('PUT', $urlPattern, $handler);
    }

    /**
     * Creates a new DELETE rest request Route.
     * @param  string $urlPattern  Router link pattern
     * @param  [type] $handler     Route operation handler
     * @return [type]             [description]
     */
    public function delete(string $urlPattern, $handler){
        $this->map('DELETE', $urlPattern, $handler);
    }

    /**
     * Creates all type of available request Route with provided parameters.
     * @param  string $urlPattern  Router link pattern
     * @param  [type] $handler     Route operation handler
     * @return [type]             [description]
     */
    public function any(string $urlPattern, $handler){
        $this->get(   $urlPattern, $handler);
        $this->post(  $urlPattern, $handler);
        $this->put(   $urlPattern, $handler);
        $this->delete($urlPattern, $handler);
    }

    public function find(callable $callback) {
        return $this->routes->find($callback);
    }

    public function getRoutes() : Iterable {
        return $this->routes;
    }

}
?>
