<?php

namespace Mantra\Routing;

use Mantra\Routing\Interfaces\IRouter;
use Mantra\Routing\RouteResolver;
use mstevz\collection\Dictionary;

class Router implements IRouter {

    /**
     * Application Route Collection
     * @see mstevz\Collection
     * @var Collection
     */
    private $_routes;

    public function __construct(){
        $this->_routes = new Dictionary();
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
        $this->_routes->add($route->getIdentity(), $route);
    }

    /**
     * Creates a new GET rest request Route.
     * @param  string $urlPattern  Router link pattern
     * @param  [type] $handler     Route operation handler
     * @return [type]             [description]
     */
    public function get(string $urlPattern, $handler){
        $this->map('get', $urlPattern, $handler);
    }

    /**
     * Creates a new POST rest request Route.
     * @param  string $urlPattern  Router link pattern
     * @param  [type] $handler     Route operation handler
     * @return [type]             [description]
     */
    public function post(string $urlPattern, $handler){
        $this->map('post', $urlPattern, $handler);
    }

    /**
     * Creates a new PUT rest request Route.
     * @param  string $urlPattern  Router link pattern
     * @param  [type] $handler     Route operation handler
     * @return [type]             [description]
     */
    public function put(string $urlPattern, $handler){
        $this->map('put', $urlPattern, $handler);
    }

    /**
     * Creates a new DELETE rest request Route.
     * @param  string $urlPattern  Router link pattern
     * @param  [type] $handler     Route operation handler
     * @return [type]             [description]
     */
    public function delete(string $urlPattern, $handler){
        $this->map('delete', $urlPattern, $handler);
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
        return $this->_routes->find($callback);
    }

    public function getRoutes() : Collection {
        return $this->_routes;
    }

}
?>
