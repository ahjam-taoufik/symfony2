<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
//use Cocur\Slugify\Slugify;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Booking;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder){

          $this->encoder=$encoder;  
    }

    public function load(ObjectManager $manager)
    {
        $faker=Factory::create('fr-FR');
        //l'ajout d'un role dans la table Role
        $adminRole=new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);
         //l'ajout d'un user admin dans la table user
          $adminUser=new User(); 
          $adminUser->setFistName('Taoufik')
                    ->setLastName('Ahjam')
                    ->setEmail('taoufikahjam@gmail.com')
                    ->setHash($this->encoder->encodePassword($adminUser,'password'))
                    ->setPicture('https://randomuser.me/api/portraits/men/94.jpg')
                    ->setIntroduction($faker->sentence())
                    ->setDescription('<p>'. join('</p><p>',$faker->paragraphs(3)).'</p>')
                    ->addUserRole($adminRole);
         $manager->persist($adminUser);


         

       //creation des utilisateurs
       $users=[];  
       $genres=['male','female'];

       for ($i=1; $i <=10 ; $i++) { 
            $user=new User();

            $genre=$faker->randomElement($genres);
             

            $picture='https://randomuser.me/api/portraits/';
            $pictureId=$faker->numberBetween(1,99). '.jpg';


            if($genre=="male") $picture=$picture.'men/'. $pictureId;
            else $picture=$picture.'women/' . $pictureId;
            //on resume ces deux ligne avec condition ternaire :
            // $picture .=($genre=="male"? 'men/' :'women/').$picturId;
             
          
            $hash=$this->encoder->encodePassword($user,'password');
            $user->setFistName($faker->firstname($genre))
                 ->setLastName($faker->lastname)
                 ->setEmail($faker->email)
                 ->setIntroduction($faker->sentence())
                 ->setDescription('<p>'. join('</p><p>',$faker->paragraphs(3)).'</p>')
                 ->setHash($hash)
                 ->setPicture($picture);


             $manager->persist($user);
             $users[]=$user;    

       }

        // creation des annonces
        //$slugify=new Slugify(); 
    for ($i=1; $i <25 ; $i++) { 
         $title=$faker->sentence();
         $coverImage=$faker->imageUrl(800,400);
         $introduction=$faker->paragraph(2);
         $content= '<p>'. join('</p><p>',$faker->paragraphs(5)).'</p>';
         //$slug=$slugify->slugify($title);
        
        $user=$users[mt_rand(0, count($users) -1 )];
           
        $Ad=new Ad();
        $Ad->setTitle($title)
           //->setSlug($slug)
           ->setCoverImage($coverImage)
           ->setIntroduction($introduction)
           ->setContent($content)
           ->setPrice(mt_rand(50,120))
           ->setRooms(mt_rand(2,5))
           ->setAuthor($user);

           for ($j=1; $j<= mt_rand(2,5) ; $j++) { 
               $image=new Image();
               $image->setUrl($faker->imageUrl())
                     ->setCaption($faker->sentence())
                     ->setAd($Ad);
                $manager->persist($image);
           }

           //gestion des reservations
           for ( $j=1; $j<= mt_rand(0,10) ; $j++) { 
                $booking=new Booking();
                $createdAt=$faker->dateTimeBetween('-6 months');
                $startDate=$faker->dateTimeBetween('-3 months');    

                $duration=mt_rand(3, 10);

                $endDate=(clone $startDate)->modify("+$duration days");
                $amount=$Ad->getPrice() * $duration;
                $booker=$users[mt_rand(0, count($users)-1)];
                 $comment=$faker->paragraph();
                $booking->setBooker($booker)
                        ->setAd($Ad)
                        ->setStartDate($startDate)
                        ->setEndDate($endDate)
                        ->setCreatedAt($createdAt)
                        ->setAmount($amount)
                        ->setComment($comment);
                $manager->persist($booking);
              
           }//end for des reservations 
         
           
        
         $manager->persist($Ad);
    }
        $manager->flush();
    }
}
