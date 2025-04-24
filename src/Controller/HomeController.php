<?php

namespace App\Controller;

use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function home():Response {

        return $this->render('home/home.html.twig', [
            'firstname' => 'Laurie',
        ]);
    }

    #[Route('/home/{firstname}', name: 'app_homeFirstname')]
    public function homeFirstname($firstname): Response {
        return new Response("Bienvenue ". $firstname);
    }

    // EXERCICES CALCULATRICE
    #[Route('/home/addition/{nbr1}/{nbr2}', name: 'app_addition')]
    public function add(int $nbr1, int $nbr2): Response {
        $total = $nbr1 + $nbr2;
        return new Response("L'addition de " .$nbr1. " et " .$nbr2. " est égale au résultat : " .$total);
    }

    #[Route('/home/calcul/{nbr1}/{nbr2}/{operator}', name: 'app_calcul')]
    public function calculatrice(int $nbr1, int $nbr2, string $operator) {
        if ($operator === "add") {
            $total = $nbr1 + $nbr2;
            $response = "L'addition de ".$nbr1. " et ".$nbr2. " est égale à ".$total;
        }
        elseif ($operator === "sous") {
            $total = $nbr1 - $nbr2;
            $response = "La soustraction de ".$nbr1. " et ".$nbr2. " est égale à ".$total;
        }
        elseif ($operator === "multi"){
            $total = $nbr1 * $nbr2;
            $response = "La multiplication de ".$nbr1. " et ".$nbr2. " est égale à ".$total;
        }
        elseif ($operator === "div"){
            $total = $nbr1 / $nbr2;
            $response = "La division de ".$nbr1. " et ".$nbr2. " est égale à ".$total;
        }
        else {
            $response = "operateur incorrect";
        }
        return new Response($response);
    }
    // COORECTION MATTHIEU
    //Test si $nbr1 et $nbr2 sont des nombres
    /* if(is_numeric($nbr1) && is_numeric($nbr2)) {
        switch($operateur) {
            //Test des cas d'operation
            case 'add': 
                $resultat = "<p>nbr1 + nbr2 est égal à : " . ($nbr1 + $nbr2) . "</p>";
                break;
            case 'sous':
                $resultat = "<p>nbr1 - nbr2 est égal à : " . ($nbr1 - $nbr2) . "</p>";
                break;
            case 'multi':
                $resultat = "<p>nbr1 x nbr2 est égal à : " . ($nbr1 * $nbr2) . "</p>";
                break;
            case 'div' :
                //Test division par 0
                if($nbr2 == 0) {
                    $resultat = "Division par zéro impossible";
                }
                else {
                    $resultat = "<p>nbr1 / nbr2 est égal à : " . ($nbr1 / $nbr2) . "</p>";
                }
                break;
            default :
                $resultat = "Opération impossible";
                break;
        }
    }
    //Sinon on affiche une erreur
    else {
        $resultat = "nbr1 ou nbr2 ne sont pas des nombres";
    }
    
    return new Response($resultat); 
} */
}
