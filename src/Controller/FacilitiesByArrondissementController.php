<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FacilitiesByArrondissementController extends AbstractController
{
    /**
     * @Route("/facilities/by/arrondissement", name="facilities_by_arrondissement")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/FacilitiesByArrondissementController.php',
        ]);
    }
}
