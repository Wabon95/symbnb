<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i < 30; $i++) {
            $slugify = new Slugify();
            $ad[$i] = new Ad();
            $ad[$i]
                ->setTitle('Annonce '.$i)
                ->setSlug($slugify->slugify('Annonce '.$i))
                ->setCoverImage('http://placehold.it/1000x300')
                ->setIntroduction('Ceci est une introduction')
                ->setContent('Ceci est un contenu')
                ->setPrice(60)
                ->setRooms(3)
            ;
            $manager->persist($ad[$i]);
        }
        $manager->flush();
    }
}
