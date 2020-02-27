<?php

namespace App\Controller;

use App\Repository\OlympicEventRepository;
use App\Repository\SportsFacilityRepository;
use App\Repository\SportsPracticeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class SportListAllOlympicSportsController extends AbstractController

{
    // Route used to display the modal information
    // return ALL OLYMPIC SPORTS infos (number of facilities + practice infos) depending of the following filters :
    // handicaps
    // arrondissement
    // level

    /**
     * @Route("/all-olympic-sports/{handicap_mobility}/{handicap_sensory}/{level}/{arrondissement}", name="all_olympic_sports")
     * @param OlympicEventRepository $olympic_repository
     * @param SportsFacilityRepository $facility_repository
     * @param $handicap_mobility
     * @param $handicap_sensory
     * @param $level
     * @param int $arrondissement
     * @return JsonResponse
     */

    public function index(OlympicEventRepository $olympic_repository, SportsFacilityRepository $facility_repository, $handicap_mobility, $handicap_sensory, $level, $arrondissement = -1) :JsonResponse
    {

        // 1 : get the list of all sports practices performed during the Olympic Games
        $practices = $olympic_repository->getAllOlympicsPractices();

        $result = [];

        // 2: get the number of facilities + format the response for each practice
        foreach ($practices as $practice) {
            $practice_id = (int)$practice['id'];
            $handicap_mobility_bool = $handicap_mobility === 'true' ? true : false;
            $handicap_sensory_bool = $handicap_sensory === 'true' ? true : false;
            $practice_level = $level === 'false' ? '' : $level;

            // get the amount of facilities where we can practice the sport practice
            $facilities_amount = $facility_repository->getNumberFacilities($practice_id, $handicap_mobility_bool, $handicap_sensory_bool, $practice_level, (int)$arrondissement);
            $facilities_amount = $facilities_amount ? (int)$facilities_amount["amount_facilities"] : 0;

            // format teh result
            array_push($result, [
                'id'=> $practice_id,
                'practice' => $practice['practice'],
                'image' => $practice['imageName'],
                'facilitiesAmount' => $facilities_amount
            ]);
        }
        return new JsonResponse($result);
    }
}
