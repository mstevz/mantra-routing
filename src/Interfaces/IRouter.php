<?php

namespace Mantra\Routing\Interfaces;

interface IRouter {
    public function map(string $method, string $urlPattern, $handler);
    public function getRoutes();
}

?>
