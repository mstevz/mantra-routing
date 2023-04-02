<?php
namespace Mantra\Routing\Controllers;

use Mantra\Routing\Attributes\Route;

class AboutController {

    #[Route('get', '/about')]
    public function get(){
        echo "hey im about";
    }

	#[Route('get', '/about2')]
    public function getAbout2(){
        echo "hello from about";
    }

    #[Route('post', '/about2')]
    public function getAbout3(){
        echo "hello from about";
    }
}

?>