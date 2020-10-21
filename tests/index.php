<?php
require_once './../vendor/autoload.php';

use Mantra\Routing\Router;
use Mantra\Routing\Dispatcher;

Use Mantra\Routing\Http\Request;
Use Mantra\Routing\Http\Uri;

Mantra\Routing\Http\Environment::load();

$router = new Router();
$dispatcher = new Dispatcher($router);

$router->get('/', 'Mantra\Routing\TestFooBar@bar');
$router->get('/bar2', 'Mantra\Routing\TestFooBar@bar2');
$router->get('/bar3', 'Mantra\Routing\TestFooBar@bar3');

echo "<pre>";

$route = $dispatcher->dispatch(Request::fromEnvironment());


$route();
?>
