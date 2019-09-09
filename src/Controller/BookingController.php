<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Form\BookingType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    /**
     * @Route("/ads/{slug}/book", name="booking_create")
     * @IsGranted("ROLE_USER")
     */
    public function book(Ad $ad, Request $request, ObjectManager $manager)
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
          // on récupere les information du formulaire
        $form->handleRequest($request);
          //Gere la validation des champs
        if($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();
            $booking->setBooker($user)
                    ->setAd($ad);
            // si les dates ne sont pas disponilbe, message d'erreur
            if(!$booking->isBookableDates()){
                $this->addFlash(
                    'warning',
                    "Les dates que vous avez choisi ne peuvent pas être réservées : elles sont déjà prises."
                );

            } else{

                $manager->persist($booking);
                $manager->flush();
                $this->addFlash(
                    'success',
                    " votre réservation auprès de <strong>{$ad->getAuthor()->getfullName()}</strong>
                    pour l'annonce <strong>{$ad->getTitle()}</strong>
                    a bien été prise en compte !"
                );
    
                return $this->redirectToRoute('booking_show', ['id' => $booking->getId()]);
            }

        }
        
        
        return $this->render('booking/book.html.twig', [
            'ad'=> $ad,
            'form'=> $form->createView()
        ]);
    }
    /**
     * permet d'afficher la page de réservation
     * @Route("/booking/{id}", name="booking_show")
     * @param Booking $booking
     * @return Response
     */
    public function show(Booking $booking){
        return $this->render('booking/show.html.twig',[
            'booking' => $booking
        ]);

    }
}
