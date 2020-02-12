<?php

namespace App\Controller;

use App\Repository\SportsPracticeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

// return the current arrondissement olympic events taking place into this same arrondissement

class ArrondissementOlympicEventController extends AbstractController
{
    /**
     * @Route("/arrondissementolympic/{id_arrondissement}/{date}", name="arrondissement_olympic_event")
     * @param SportsPracticeRepository $repository
     * @param $id_arrondissement
     * @param $date
     * @return void
     */
    public function index(SportsPracticeRepository $repository, $id_arrondissement, $date)
    {
        $response = $repository->getArrondissementCurrentEvents($id_arrondissement, $date);
        return $response;

       // ex params to have a result:
        // arrondissement: 7
        // date: 2024-07-27
    }
}
