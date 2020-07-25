<?php

namespace Mantra\Routing;

use Mantra\Routing\{ RouteResolver,
                     RouteIdentifier };
use Mantra\Routing\Interfaces\IRoute;

class Route {

    private $httpMethod;
    private $urlPattern;
    protected $resolver;

    protected $identity;

    /**
     *
     * @param string $method     [description]
     * @param string $urlPattern [description]
     * @param string $handler    Handler Identifier
     */
    public function __construct(string $httpMethod, string $urlPattern, RouteResolver $resolver){
        $this->identity   = RouteIdentifier::getIdentity($httpMethod, $urlPattern);
        $this->httpMethod = $httpMethod;
        $this->urlPattern = $urlPattern;
        $this->resolver   = $resolver;
    }

    public function getIdentity() : string {
        return $this->identity;
    }

    public function getResolver() : RouteResolver {
        return $this->resolver;
    }

    public function __invoke() {
        $this->getResolver()();
    }
}

?>
