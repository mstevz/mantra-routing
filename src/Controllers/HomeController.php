<?php
namespace Mantra\Routing\Controllers;

use Mantra\Routing\Attributes\{Route, Get, Post, Put, Delete};

class HomeController {

    #[Route('get', '/home/{name}/id/{id:int}')]
    public function getHome(string $name, int $a){
        echo "Hello $name, your age is $a";
    }

    #[Get('/home/images')]
    public function getImages(){
        echo 'hello';
    }

	#[Put('put', '/')]
    public function putHome(){
        echo "hello from about";
    }

    #[Post('post', '/')]
    public function postHome(){
        echo "hello from about";
    }

    #[Delete('/home2')]
    public function deleteHome(){
        echo "hello from about";
    }
}

?>