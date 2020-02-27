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

            $practice_id = (int)$practice['id'];
            $handicap_mobility_bool = $handicap_mobility === 'true' ? true : false;
            $handicap_sensory_bool = $handicap_sensory === 'true' ? true : false;
            $practice_level = $level === 'false' ? '' : $level;
            $arrondissement = (int)$arrondissement;

            // 2: get the number of facilities + format the result for each practice ----------------------------
            $facilities_amount = $this->getFacilitiesAmount($facility_repository, $practice_id, $handicap_mobility_bool, $handicap_sensory_bool, $practice_level, $arrondissement);
            $olympic_practices_information = $this->addResult($olympic_practices_information, $practice_id, $practice['practice'], $practice['image_name'], $facilities_amount);


            // 3: get the number of facilities + format the response for each related sports practices ----------------------


            $sports_families_id = $family_repository->getAllFamiliesOfAPractice($practice_id);
            $sports_families_practices_id = $practice_repository->getAllPracticesIdForFamilySports($sports_families_id);

            foreach ($sports_families_practices_id as $id) {

                // exclude the sport if it already is in the result (due to his link with multiple sports families)
                $is_in_array = $this->isInArray($families_practices_data, $id);


                // exclude the sport if it already is in the Olympic Games of the selected day
                $is_in_array = $is_in_array ? $is_in_array : $this->isInArray($practices, $id);

                if ($id !== $practice_id && !$is_in_array) {
                    // get the amount of facilities where we can practice the sport practice
                    $facilities_amount = $this->getFacilitiesAmount($facility_repository, $id, $handicap_mobility_bool, $handicap_sensory_bool, $practice_level, $arrondissement);

                    $practice_data = $practice_repository->getOnePracticeData($id);

                    // format the result for each practice
                    $families_practices_data = $this->addResult($families_practices_data, $id, $practice_data[0]['practice'], $practice_data[0]['image_name'], $facilities_amount);
                }
            }
        }

        $response = ['olympicSports' => $olympic_practices_information,
            'relatedSports' => $families_practices_data];

        return new JsonResponse($response);
    }




    private function getFacilitiesAmount (SportsFacilityRepository $facility_repository, $id, $handicap_mobility, $handicap_sensory, $level, $arrondissement) {
        $facilities_amount = $facility_repository->getNumberFacilities($id, $handicap_mobility, $handicap_sensory, $level, $arrondissement);
        return $facilities_amount ? (int)$facilities_amount["amount_facilities"] : 0;
    }

    private function addResult($array, $id, $practice_name, $practice_image, $facilities_amount) :array {
        array_push($array, [
            'id' => $id,
            'practice' => $practice_name,
            'image' => $practice_image,
            'facilityAmount' => $facilities_amount
        ]);
        return $array;
    }

    private function isInArray ($array, $id) :bool {
        foreach ($array as $element_to_check) {
            if ((int)$element_to_check['id'] === $id) {
                return true;
            }
        }
        return false;
    }
}
