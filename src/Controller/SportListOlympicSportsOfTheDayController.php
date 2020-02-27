<?php

namespace App\Controller;

use App\Repository\SportsFacilityRepository;
use App\Repository\SportsFamilyRepository;
use App\Repository\SportsPracticeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class SportListOlympicSportsOfTheDayController extends AbstractController
{
    // Route used to display the modal information
    // return olympic sports information + their related sports information (number of facilities + practice info) depending of the following filters :
    // date
    // handicaps
    // arrondissement
    // level

    /**
     * @Route("/olympic-sports-of-the-day/{date}/{handicap_mobility}/{handicap_sensory}/{level}/{arrondissement}", name="olympic_sports_of_the_day")
     * @param SportsPracticeRepository $practice_repository
     * @param SportsFacilityRepository $facility_repository
     * @param SportsFamilyRepository $family_repository
     * @param $date
     * @param $handicap_mobility
     * @param $handicap_sensory
     * @param $level
     * @param $arrondissement
     * @return JsonResponse
     */

    public function index(SportsPracticeRepository $practice_repository, SportsFacilityRepository $facility_repository, SportsFamilyRepository $family_repository, $date, $handicap_mobility, $handicap_sensory, $level, $arrondissement = -1) :JsonResponse
    {
        // 1 : get the list of all sports practices performed during the Olympic Games on $date
        $practices = $practice_repository->getAllOlympicsPracticesByDate($date);

        $olympic_practices_information = [];
        $families_practices_data = [];

        foreach ($practices as $practice) {

            // 2: get the number of facilities + format the response for each practice ----------------------------

            $practice_id = (int)$practice['id'];
            $handicap_mobility_bool = $handicap_mobility === 'true' ? true : false;
            $handicap_sensory_bool = $handicap_sensory === 'true' ? true : false;
            $practice_level = $level === 'false' ? '' : $level;
            $arrondissement = (int)$arrondissement;

            // get the amount of facilities where we can practice the sport practice
            $facilities_amount = $facility_repository->getNumberFacilities($practice_id, $handicap_mobility_bool, $handicap_sensory_bool, $practice_level, $arrondissement);
            $facilities_amount = $facilities_amount ? (int)$facilities_amount["amount_facilities"] : 0;

            array_push($olympic_practices_information, [
                'id'=> $practice_id,
                'practice' => $practice['practice'],
                'image' => $practice['image_name'],
                'facilitiesAmount' => $facilities_amount
            ]);



            // 3: get the number of facilities + format the response for each related sports ----------------------

            $sports_families_id = $family_repository->getAllFamiliesOfAPractice($practice_id);
            $sports_families_practices_id = $practice_repository->getAllPracticesIdForFamilySports($sports_families_id);

            foreach ($sports_families_practices_id as $id) {
                $is_in_array = false;

                foreach ($families_practices_data as $practice_to_check) {
                    if ($practice_to_check['id'] === $id) {
                        $is_in_array = true;
                    }
                }

                // if the sport is already one of the JO
                foreach ($practices as $olympic_practice) {
                    if ((int)$olympic_practice['id'] === $id) {
                        $is_in_array = true;
                    }
                }

                if ($id !== $practice_id && !$is_in_array) {
                    $facilities_amount = $facility_repository->getNumberFacilities($id, $handicap_mobility_bool, $handicap_sensory_bool, $practice_level, $arrondissement);
                    $facilities_amount = $facilities_amount ? (int)$facilities_amount["amount_facilities"] : 0;

                    $practice_data = $practice_repository->getOnePracticeData($id);

                    array_push($families_practices_data, [
                        'id' => $id,
                        'practice' => $practice_data[0]['practice'],
                        'image' => $practice_data[0]['image_name'],
                        'facilityAmount' => $facilities_amount
                    ]);
                }
            }
        }

        $response = ['olympicSports' => $olympic_practices_information,
            'relatedSports' => $families_practices_data];

        return new JsonResponse($response);
    }
}
