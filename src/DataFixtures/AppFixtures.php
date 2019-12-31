<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
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

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);
        $adminUser = new User();
        $adminUser
            ->setFirstname('David')
            ->setLastname('Bonaglia')
            ->setEmail('dbonaglia95@protonmail.com')
            ->setIntroduction($faker->sentence())
            ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>')
            ->setHash($this->encoder->encodePassword($adminUser, 'dadadada'))
            ->setPicture('http://placehold.it/128x128')
            ->addUserRole($adminRole)
        ;
        $manager->persist($adminUser);

        $content = '';
        for ($c=0; $c < 5; $c++) { $content .= '<p>'.$faker->paragraph(mt_rand(3, 5)).'</p>';}

        $genres = ['male', 'female'];
        for ($i=1; $i <= 10; $i++) { 
            $user[$i] = new User();
            $user[$i]
                ->setFirstname($faker->firstname($faker->randomElement($genres)))
                ->setLastname($faker->lastname())
                ->setEmail($faker->email())
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>')
                ->setHash($this->encoder->encodePassword($user[$i], 'dadadada'))
                ->setPicture('http://placehold.it/128x128')
            ;
            $manager->persist($user[$i]);
        }

        // Ads
        for ($i=1; $i < 30; $i++) {
            shuffle($user);
            $ad[$i] = new Ad();
            $ad[$i]
                ->setTitle('Annonce '.$i)
                ->setCoverImage($faker->imageUrl(1000,350))
                ->setContent($content)
                ->setIntroduction($faker->paragraph(2))
                ->setPrice(mt_rand(40, 100))
                ->setRooms(mt_rand(1, 4))
                ->setAuthor($user[1])
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

            // Booking
            for ($j=1; $j <= mt_rand(0, 10); $j++) { 
                $booking = new Booking();

                $createdAt = $faker->dateTimeBetween('-6 months');
                $startDate = $faker->dateTimeBetween('-3 months');
                $duration  = mt_rand(3, 10);
                $endDate   = (clone $startDate)->modify("+$duration days");
                $amount    = $ad[$i]->getPrice() * $duration;
                $booker    = $user[mt_rand(0, count($user) -1)];
                $comment   = $faker->paragraph();

                $booking
                    ->setBooker($booker)
                    ->setAd($ad[$i])
                    ->setStartDate($startDate)
                    ->SetEndDate($endDate)
                    ->setCreatedAt($createdAt)
                    ->setAmount($amount)
                    ->setComment($comment)
                ;
                $manager->persist($booking);
            }
            $manager->persist($ad[$i]);
        }
        $manager->flush();
    }
}
