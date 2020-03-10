<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
//use Cocur\Slugify\Slugify;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker=Factory::create('fr-FR');
        //$slugify=new Slugify();
        
    for ($i=1; $i <25 ; $i++) { 
         $title=$faker->sentence();
         $coverImage=$faker->imageUrl(800,400);
         $introduction=$faker->paragraph(2);
         $content= '<p>'. join('</p><p>',$faker->paragraphs(5)).'</p>';
         //$slug=$slugify->slugify($title);

        $Ad=new Ad();
        $Ad->setTitle($title)
           //->setSlug($slug)
           ->setCoverImage($coverImage)
           ->setIntroduction($introduction)
           ->setContent($content)
           ->setPrice(mt_rand(50,120))
           ->setRooms(mt_rand(2,5));

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
