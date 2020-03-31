<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {
      /**
       * @Route("/hello/{prenom}",name="hello")
       * Montrer la page qui dit hello
       *
       * @return void
       */
     public function hello($prenom = "anonyme"){
          return new Response("hello puta" .$prenom );
     }
   
     /**
      * @Route("/",name="homepage")
      */

    public function home(){
       return $this->render(
            'home.html.twig',
            ['title' => "bonjour zin"]
       );
    }

}




?>