<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        for ($i=1; $i < 30; $i++) {
            $ad[$i] = new Ad();
            $ad[$i]
                ->setTitle('Annonce '.$i)
                ->setCoverImage($faker->imageUrl(1000,350))
                ->setIntroduction($faker->paragraph(2))
                ->setContent($faker->paragraph(5))
                ->setPrice(mt_rand(40, 100))
                ->setRooms(mt_rand(1, 4))
            ;
            $manager->persist($ad[$i]);
        }
        $manager->flush();
    }
}
