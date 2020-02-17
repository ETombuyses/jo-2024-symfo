<?php

namespace App\Controller;

use App\Repository\SportsFacilityRepository;
use App\Repository\SportsFamilyRepository;
use App\Repository\SportsPracticeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


// return modal sports informations if no sport selected but a date selected

class SportListNoSportSelectedController extends AbstractController
{
    /**
     * @Route("/sport/list/no/sport/selected/{date}/{handicap_mobility}/{handicap_sensory}/{level}/{arrondissement}", name="sport_list_no_sport_selected")
     * @param SportsPracticeRepository $practice_repository
     * @param SportsFacilityRepository $facility_repository
     * @param $date
     * @param $handicap_mobility
     * @param $handicap_sensory
     * @param $level
     * @return JsonResponse
     */
    public function index(SportsPracticeRepository $practice_repository, SportsFacilityRepository $facility_repository, SportsFamilyRepository $family_repository, $date, $handicap_mobility, $handicap_sensory, $level, $arrondissement = -1)
    {

        $practices = $practice_repository->getAllOlympicsPracticesByDate($date);

        $olympic_practice_informations = [];
        $families_practice_data = [];

        foreach ($practices as $practice) {
            $practice_id = (int)$practice['id'];
            $handicap_mobility_bool = $handicap_mobility === 'true' ? true : false;
            $handicap_sensory_bool = $handicap_sensory === 'true' ? true : false;
            $practice_level = $level === 'false' ? '' : $level;
            $arrondissement = (int)$arrondissement;

            $amount = $facility_repository->getAmountFacilities($practice_id, $handicap_mobility_bool, $handicap_sensory_bool, $practice_level, $arrondissement);
            $amount = $amount ? (int)$amount["amount_facilities"] : 0;

            array_push($olympic_practice_informations, [
                'id_practice'=> $practice_id,
                'practice' => $practice['practice'],
                'image' => $practice['image_name'],
                'facilitiesAmount' => $amount
            ]);

            // ---------------------- get related sports data -----------------------------------

            $sports_families_id = $family_repository->getAllFamiliesOfAPractice($practice_id);

            $sports_families_practices_id = $practice_repository->getAllPracticesIdForFamilySports($sports_families_id);

            foreach ($sports_families_practices_id as $id) {
                $is_in_array = false;

                foreach ($families_practice_data as $practice_to_check) {
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
                    $amount = $facility_repository->getAmountFacilities($id, $handicap_mobility_bool, $handicap_sensory_bool, $practice_level, $arrondissement);
                    $amount = $amount ? (int)$amount["amount_facilities"] : 0;

                    $practice_data = $practice_repository->getOnePracticeData($id);

                    $selected_practice_data_family = [
                        'id' => $id,
                        'practice' => $practice_data[0]['practice'],
                        'image' => $practice_data[0]['image_name'],
                        'facilityAmount' => $amount
                    ];

                    array_push($families_practice_data, $selected_practice_data_family);
                }
            }
        }




        $response = ['olympicSports' => $olympic_practice_informations,
            'relatedSports' => $families_practice_data];

        return new JsonResponse($response);
    }
}
