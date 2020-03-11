<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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

    
    /**
     * @Route("/ads/new",name="ads-create")
     * 
     */
    public function create(Request $request, EntityManagerInterface $manager){
          $ad=new Ad();
        
        // ce block pour test l'ajout d'un sous formulaire
        //   $image=new Image();
        //   $image->setUrl("https://via.placeholder.com/1000x400")
        //         ->setCaption('titre1');
        //   $ad->addImage($image);


          $form=$this->createForm(AdType::class,$ad);
          // handle c'est t'a dire gére la request
          $form->handleRequest($request);
            // dump($ad);
           

       /*     
            /// des messgaes pour tester  
            $this->addFlash(
                'danger',
                " l'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrer error "
            );
                
            $this->addFlash(
                'success',
                " l'annonce <strong>test</strong> <strong>{$ad->getTitle()}</strong> a bien été enregistrer "
          );
      */
            


            if ($form->isSubmitted() && $form->isValid()) {
                 foreach ($ad->getImages() as $image) {
                     $image->setAd($ad);
                     $manager->persist($image);
                 }

                //$manager=$this->getDoctrine()->getManager();
                $manager->persist($ad);
                $manager->flush();  
                
                $this->addFlash(
                      'success',
                      " l'annonce <strong>test</strong> <strong>{$ad->getTitle()}</strong> a bien été enregistrer "
                );

               return $this->redirectToRoute('ad-show',[
                       'slug'=>$ad->getSlug()
               ]);          
           }

        /*  // creer un formulaire avec FormBuilder
        $form=$this->createFormBuilder($ad)
                     ->add('title')
                     ->add('introduction')
                     ->add('content')
                     ->add('rooms')
                     ->add('price')
                     ->add('coverImage')
                     ->add('save',SubmitType::class,[
                         'label'=>'creer la nouvelle annonce'
                         'attr'=>[
                             'class'=>'btn btn-primary'
                         ]
                     ])
                     ->getForm();  */
        return $this->render('ad/create.html.twig',[
               'form'=>$form->createView(),
              
        ]);
    }


/**
 * 
 * @Route("/ads/{slug}/edit" , name="ads_edit")
 * 
 */
  public function edit(Ad $ad, Request $request, EntityManagerInterface $manager){

    $form=$this->createForm(AdType::class,$ad);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        foreach ($ad->getImages() as $image) {
            $image->setAd($ad);
            $manager->persist($image);
        }

       $manager->persist($ad);
       $manager->flush();  
       
       $this->addFlash(
             'success',
             " l'annonce <strong>test</strong> <strong>{$ad->getTitle()}</strong> a bien été modifier "
       );

      return $this->redirectToRoute('ad-show',[
              'slug'=>$ad->getSlug()
      ]);          
  }

      return $this->render('ad/edit.html.twig',[
        'form'=>$form->createView(),
        'ad'=>$ad

      ]);
  }
  


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





