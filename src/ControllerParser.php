<?php

namespace Mantra\Routing;

class ControllerParser {

    private $_namespace;
    private $_className;
    private $_method;

    /**
     * [__construct description]
     * @param [type] $handler [description]
     */
    public function __construct($handler){
        $this->_namespace = null;
        $this->_className = null;
        $this->_method    = null;
        $this->_callable  = null;

        $this->_isCallable = false;

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

        $this->_namespace = $fragments[0];
        $this->_method = $fragments[1];

        $namespaceFragments = explode('\\', $this->_namespace);

        $this->_className = array_pop($namespaceFragments);

    }

    public function getNamespace() {
        return $this->_namespace;
    }

    public function getClassName() {
        return $this->_className;
    }

    public function invokeControllerMethod(){
        $controller = new $this->_namespace;

        $controller->{$this->_method}();
    }

}

?>
