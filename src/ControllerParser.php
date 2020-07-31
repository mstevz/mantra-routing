<?php

namespace Mantra\Routing;

class ControllerParser {

    private $namespace;
    private $className;
    private $method;

    /**
     * [__construct description]
     * @param [type] $handler [description]
     */
    public function __construct($handler){
        $this->namespace = null;
        $this->className = null;
        $this->method    = null;
        $this->callable  = null;

        $this->isCallable = false;

        $this->parse($handler);
    }

    /**
     * [parse description]
     * @param  [type] $value [description]
     * @throws InvalidArgumentException
     *
     * @return [type]        [description]
     */
    private function parse($value){
        if(!is_string($value)){
            throw new \InvalidArgumentException("Argument \"${handler}\" must be of type \"string\" or a callable.");
        }

        $fragments = explode('@', $value);

        $this->namespace = $fragments[0];
        $this->method = $fragments[1];

        $namespaceFragments = explode('\\', $this->namespace);

        $this->className = array_pop($namespaceFragments);

    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getClassName() {
        return $this->className;
    }

    public function invokeControllerMethod(){
        $controller = new $this->namespace;

        $controller->{$this->method}();
    }

}

?>
