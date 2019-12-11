<?php

namespace App\Controller;

use App\Repository\AdRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController {

    /** @Route("/ads", name="ads_index") */
    public function index(AdRepository $ar) {
        return $this->render('ad/index.html.twig', [
            'ads' => $ar->findAll()
        ]);
    }

    /** @Route("/ads/{slug}", name="ads_show") */
    public function show($slug, AdRepository $ar) {
        return $this->render('ad/show.html.twig', [
            'ad' => $ar->findOneBySlug($slug)
        ]);
    }
}
