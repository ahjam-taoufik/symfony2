<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class HomeController  extends AbstractController{

    /** 
    *@Route("/", name="home")
    *
    */
   public function home(){
        return $this->render('home.html.twig');
   }

     /** 
    *@Route("/about", name="about")
    *
    */
    public function about(){
     return $this->render('about.html.twig');
}

}



