<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
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
    public function create (Request $request, ObjectManager $manager)
    {
        $ad = new Ad();


        $form = $this->createForm(AdType::class,$ad);
        // on récupere les information du formulaire
        $form->handleRequest($request);
        //Gere la validation des champs
        if($form->isSubmitted() && $form->isValid()){

            foreach($ad->getImages() as $image){
                $image->setAd($ad);
                $manager->persist($image);
            }

            $ad->setAuthor($this->getUser());
            // fait persister les info dans la BDD
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "l'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée"
            );

            // redirection vers l'annonce que l'on vient de créer.
            return $this->redirectToRoute('ads_show', [
                'slug'=>$ad->getSlug()
            ]);

        }

        return $this->render('ad/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

/**
 * Permet d'afficher le formulaire d'édition
 * 
 * @Route("/ads/{slug}/edit", name="ads_edit")
 *
 * @return Response
 */
    public function edit(Ad $ad, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(AdType::class,$ad);
        // on récupere les information du formulaire
        $form->handleRequest($request);

        //Gere la validation des champs
        if($form->isSubmitted() && $form->isValid()){

            foreach($ad->getImages() as $image){
                $image->setAd($ad);
                $manager->persist($image);
            }


            // fait persister les info dans la BDD
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "les modifications de l'annonce <strong>{$ad->getTitle()}</strong> ont bien été enregistrées"
            );

            // redirection vers l'annonce que l'on vient de créer.
            return $this->redirectToRoute('ads_show', [
                'slug'=>$ad->getSlug()
            ]);

        }

        return $this->render('ad/edit.html.twig',[
            'form'=> $form->createView(),
            'ad'=> $ad
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
