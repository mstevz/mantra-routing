<?php

namespace Mantra\Routing;

use Mantra\Routing\ControllerParser;

class RouteResolver {

    protected $value;
    private $parser;

    public function __construct($value){
        $this->value = $value;
        $this->parser = new ControllerParser($value);
    }

    public function getParser() : ControllerParser {
        return $this->parser;
    }

    public function getValue() {
        return $this->value;
    }

    public function __invoke(){
        $this->getParser()->invokeControllerMethod();
    }

}

?>
