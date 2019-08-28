<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ad_index")
     */
    public function index(AdRepository $repo)
    {
        //dump($session);
        //$repo = $this->getDoctrine()->getRepository(Ad::class);

        $ads = $repo-> findAll();
        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }

    /**
     * Permet de voir le détail d'une fonction
     *
     * @Route("/ads/{slug}", name="ads_show")
     * @return Response
     */
    public function show ($slug, AdRepository $repo)
    {
        // je récupère l'annonce qui correspond au slug
        $ad = $repo->findOneBySlug($slug);

        return $this->render('ad/show.html.twig',[
            'ad' => $ad,
        ]);
    }
}
