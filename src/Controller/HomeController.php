<?php 
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller{
  

    /**
     * @Route("/", name="homepage")
     */
    public function home()
    {
        return $this->render('/home.html.twig',[
            'title' => "Bienvenue ici les amis",
            'age'=> 31
        ]);

    }
    
/**
 * @Route("/hello/{prenom}", name="hellopage")
 *
 * @return void
 */
    public function hello($prenom = "annonyme")
    {
        return new Response("bonjour" . $prenom );
    }

}      

?>