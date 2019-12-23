<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController {

    /** @Route("/ads", name="ads_index") */
    public function index(AdRepository $ar) {
        return $this->render('ad/index.html.twig', [
            'ads' => $ar->findAll()
        ]);
    }

    /** @Route("/ads/new", name="ads_create") */
    public function create(Request $request, EntityManagerInterface $manager) {
        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }
            $ad->setAuthor($this->getUser());
            $manager->persist($ad);
            $manager->flush();
            $this->addFlash('success', "L'annonce <strong>{$ad->getTitle()}</strong> à bien été enregistrée !");
            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }
        return $this->render('ad/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /** @Route("/ads/{slug}", name="ads_show") */
    public function show(Ad $ad) {
        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    }
}