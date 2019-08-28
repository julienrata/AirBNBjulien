<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
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
     * Permet de créer une annonce
     *
     * @Route("/ads/new", name="ads_create")
     * @return Response
     */
    public function create ()
    {
        $ad = new Ad();
        $form = $this->createForm(AdType::class,$ad);
        return $this->render('ad/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de voir le détail d'une fonction
     *
     * @Route("/ads/{slug}", name="ads_show")
     * @return Response
     */
    public function show ($slug, Ad $ad)
    {
        // je récupère l'annonce qui correspond au slug
        //$ad = $repo->findOneBySlug($slug);

        return $this->render('ad/show.html.twig',[
            'ad' => $ad,
        ]);
    }

}
