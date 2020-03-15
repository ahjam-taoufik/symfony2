<?php

namespace App\Controller;

use App\Repository\AdRepository;
use App\Services\PaginationServices;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdController extends AbstractController
{
    /**
     * @Route("/admin/ads/{page}", name="admin_ads_index",requirements={"page":"\d+"})
     */
    public function index(AdRepository $repo, $page=1, PaginationServices $pagine)
    {
        $test=$pagine->getInformation();
        dump($test);
        die();
        $limit=10;
        $start= $page * $limit - $limit;
        $total=count($repo->findAll());
        $pages=ceil($total/$limit);
        //findBy([les critères],[par ordre ],[nombre d'enregistrement affichie parpage],[a partir de ou en comence])
      
        return $this->render('admin/ad/index.html.twig', [
            'ads'=>$repo->findBy([],[],$limit,$start),
            'pages'=>$pages,
            'page'=>$page
        ]);
    }
}
