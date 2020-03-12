<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
//use Cocur\Slugify\Slugify;
use App\Entity\User;
use App\Entity\Image;
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
           
         // $product = new Product();
         $manager->persist($Ad);
    }
        $manager->flush();
    }
}
