<?php

namespace App\Controller;

use App\Repository\SportsPracticeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SportListNoSportSelectedController extends AbstractController
{
    /**
     * @Route("/sport/list/no/sport/selected/{date}/{handicap_mobility}/{handicap_sensory}/{level}", name="sport_list_no_sport_selected")
     * @param SportsPracticeRepository $repository
     * @param $date
     * @param $handicap_mobility
     * @param $handicap_sensory
     * @param $level
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(SportsPracticeRepository $repository, $date, $handicap_mobility, $handicap_sensory, $level)
    {
        // first get all the practices for every olympic event of the selected date
        $practices = $repository->getAllOlympicsPractices($date);
        return $practices;
    }
}
