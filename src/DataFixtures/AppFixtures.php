<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Post;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        
        $faker = Factory::create('fr-FR');

        $files = glob('public/images/*.jpg');
            
        for ($i=0; $i < 10; $i++) { 

            // load a random image from the public folder
            $file = array_rand($files);
            // cut the public/ part from the path
            $parts = explode("/", $files[$file]);
            $urlimg = $parts[1] . '/' . $parts[2];
            
            $article = new Article();
            $article->setTitle($faker->sentence($nb_words=2, $variableNbWords=true))
            ->setContent($faker->sentence($nb_words=10, $variableNbWords=true))
            ->setUrlimage($urlimg);

            $manager->persist($article);
        }

        $manager->flush();
    }

}
