<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        $error=$utils->getLastAuthenticationError();
        $username=$utils->getLastUsername();
      
        return $this->render('account/login.html.twig',[
            'hasError'=>$error !==null,
            'username'=>$username
        ]);
    }


    /**
     * @Route("/logout", name="account_logout")
     */
    public function logout(){
        // .. rien
    }


    /**
     * @Route("/register", name="account_register")
     */
    public function register(Request $request,EntityManagerInterface $manager,
         UserPasswordEncoderInterface $encoder ){

        $user=new User();
        $form=$this->createForm(RegistrationType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash=$encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);

            $manager->persist($user);
            $manager->flush();
             
       $this->addFlash(
        'success',
        " votre compte a bien été creerrrrrr "
           );

           return $this->redirectToRoute('account_login');

        }

       return $this->render('account/registration.html.twig',[
           'form'=>$form->createView()
       ]);

    }

     /**
     * @Route("/account/profile", name="account_profile")
     */
    public function profile(Request $request,EntityManagerInterface $manager){
          $user=$this->getUser();
          $form=$this->createForm(AccountType::class,$user);

        
          $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
             
       $this->addFlash(
        'success',
        " votre profil a bien été modifier "
           );

           return $this->redirectToRoute('account_login');

        }
          
           return $this->render('account/profile.html.twig',[
               'form'=> $form->createView()
           ]);
    }

    /**
     * @Route("/account/password-update", name="account_password")
     *
     * @return 
     */
    public function updatePassword(Request $request,EntityManagerInterface $manager,
    UserPasswordEncoderInterface $encoder){
        $passwordUpdate= new PasswordUpdate();
        $user=$this->getUser();
               
    
        $form=$this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             if (!password_verify($passwordUpdate->getOldPassword(),$user->getHash())) {
                  $form->get('oldPassword')->addError(new FormError("le mot de passe que vous avez tapé
                  n'est pas votre mot de passe actuel"));
             }else{
                $newPassword=$passwordUpdate->getNewPassword();
                $hash=$encoder->encodePassword($user,$newPassword);
                $user->setHash($hash);

                $manager->persist($user);
                $manager->flush();
                $this->addFlash(
                    'success',
                    " votre mot de passe a bien été modifier "
                       );
            
                       return $this->redirectToRoute('home');

             }//end if
        }//valid
        return $this->render('account/password.html.twig',[
              'form'=>$form->createView()

        ]);
    }

    /**
     * @Route("/account", name="account_index")
     *
     */
    public function myAccount (){
        return $this->render('user/index.html.twig',[
            'user'=>$this->getUser()
        ]);
    }




}

