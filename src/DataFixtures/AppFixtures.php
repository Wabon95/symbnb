<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');
        $content = '';
        for ($c=0; $c < 5; $c++) { $content .= '<p>'.$faker->paragraph(mt_rand(3, 5)).'</p>';}


        for ($i=1; $i < 30; $i++) {
            $ad[$i] = new Ad();
            $ad[$i]
                ->setTitle('Annonce '.$i)
                ->setCoverImage($faker->imageUrl(1000,350))
                ->setContent($content)
                ->setIntroduction($faker->paragraph(2))
                ->setPrice(mt_rand(40, 100))
                ->setRooms(mt_rand(1, 4))
            ;

            for ($j=1; $j < mt_rand(2, 5); $j++) { 
                $image[$j] = new Image();
                $image[$j]
                    ->setUrl($faker->imageUrl())
                    ->setCaption($faker->sentence())
                    ->setAd($ad[$i])
                ;
                $manager->persist($image[$j]);
            }
            $manager->persist($ad[$i]);
        }
        $manager->flush();
    }
}
