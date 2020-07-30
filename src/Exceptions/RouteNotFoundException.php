<?php

namespace Mantra\Routing\Exceptions;

final class RouteNotFoundException extends \Exception {

    public function __construct($routeName, $code = 0, Exception $previous = null) {
        // make sure everything is assigned properly
        parent::__construct("404: Route \"{$routeName}\" was not found.", $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
?>
