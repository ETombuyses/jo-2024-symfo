<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FacilitiesByArrondissementSportSelectedController extends AbstractController
{
    /**
     * @Route("/facilities/by/arrondissement/sport/selected", name="facilities_by_arrondissement_sport_selected")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/FacilitiesByArrondissementSportSelectedController.php',
        ]);
    }
}
