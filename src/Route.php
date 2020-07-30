<?php

namespace Mantra\Routing;

use Mantra\Routing\RouteResolver;
use Mantra\Routing\Interfaces\IRoute;

class Route {

    private $httpMethod;
    private $urlPattern;
    protected $resolver;

    /**
     *
     * @param string $method     [description]
     * @param string $urlPattern [description]
     * @param string $handler    Handler Identifier
     */
    public function __construct(string $httpMethod, string $urlPattern, RouteResolver $resolver){
        $this->httpMethod = $httpMethod;
        $this->urlPattern = $urlPattern;
        $this->resolver   = $resolver;
    }

    public function getResolver() : RouteResolver {
        return $this->resolver;
    }

    public function getPattern() : string {
        return $this->urlPattern;
    }

    public function __invoke() {
        $this->getResolver()();
    }
}

?>
