<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads-index")
     */
    public function index(AdRepository $repo){
       //$repo=$this->getDoctrine()->getRepository(Ad::class);

       $ads=$repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads'=>$ads
        ]);
    }

/////////////////////////////////////////////////////////////////////
    //la methode show avec Repositorey (injection de dependence)
/////////////////////////////////////////////////////////////////////
     /**
     *@Route("/ads/{slug}",name="ad-show")
     *@return Response
     */
    // public function show($slug,AdRepository $repo ){

    //     $ad=$repo->findOneBySlug($slug);
    //     return $this->render('ad/show.html.twig',[
    //            'ad'=>$ad 
    //     ]);
    // }
////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////
    //la methode show avec ParamConervter (injection de dependence)
/////////////////////////////////////////////////////////////////////

        /**
         * @Route("/ads/{slug}",name="ad-show")
        * 
        */
        public function show(Ad $ad){
            return $this->render('ad/show.html.twig',[
                'ad'=>$ad 
            ]);
        }




}
