<?php

namespace App\Controller;

use App\Repository\SportsFacilityRepository;
use App\Repository\SportsPracticeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SportListAllOlympicSportController extends AbstractController
{
    /**
     * @Route("/sport/list/all/olympic/sport/{handicap_mobility}/{handicap_sensory}/{level}", name="sport_list_all_olympic_sport")
     * @param SportsPracticeRepository $practice_repository
     * @param SportsFacilityRepository $facility_repository
     * @param $handicap_mobility
     * @param $handicap_sensory
     * @param $level
     * @return JsonResponse
     */
    public function index(SportsPracticeRepository $practice_repository, SportsFacilityRepository $facility_repository, $handicap_mobility, $handicap_sensory, $level = '')
    {
        // for now, all parameters are required
        // ex:
        // $date = 2024-07-26
        // $handicap_mobility = boolean
        // $handicap_sensory = boolean
        // $level = string ('false' if no level selected)

        // first get all the practices for every olympic event
        $practices = $practice_repository->getAllOlympicsPractices();

        $result = [];

        foreach ($practices as $practice) {
            $practice_id = (int)$practice['id'];
            $handicap_mobility_bool = $handicap_mobility === 'true' ? true : false;
            $handicap_sensory_bool = $handicap_sensory === 'true' ? true : false;
            // TODO : find how to make a parameter optional (not make a second route because it is the same code, only the param changes
            $practice_level = $level === 'false' ? '' : $level;
            $amount = $facility_repository->getAmountFacilities($practice_id, $handicap_mobility_bool, $handicap_sensory_bool, $practice_level);

            array_push($result, [
                'id_practice'=> $practice_id,
                'practie' => $practice['practice'],
                'image' => $practice['image_name'],
                'facilitiesAmount' => $amount
            ]);
        }
        return new JsonResponse($result);
    }
}
