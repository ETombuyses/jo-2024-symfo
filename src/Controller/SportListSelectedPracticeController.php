<?php

namespace App\Controller;

use App\Repository\SportsFacilityRepository;
use App\Repository\SportsFamilyRepository;
use App\Repository\SportsPracticeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SportListSelectedPracticeController extends AbstractController
{

    // Route used to display the modal information
    // return the selected olympic sport's information + its related sports information (number of facilities + practice info) depending of the following filters :
    // handicaps
    // arrondissement
    // level

    /**
     * @Route("/selected-sport/{id_practice}/{handicap_mobility}/{handicap_sensory}/{level}/{arrondissement}", name="sport_list_selected_practice")
     * @param SportsFacilityRepository $facility_repository
     * @param SportsPracticeRepository $practice_repository
     * @param SportsFamilyRepository $family_repository
     * @param $id_practice
     * @param $handicap_mobility
     * @param $handicap_sensory
     * @param $level
     * @param $arrondissement
     * @return JsonResponse
     */
    public function index(SportsFacilityRepository $facility_repository, SportsPracticeRepository $practice_repository, SportsFamilyRepository $family_repository, $id_practice, $handicap_mobility, $handicap_sensory, $level, $arrondissement = -1) :JsonResponse
    {

        $practice_id = (int)$id_practice;
        $handicap_mobility_bool = $handicap_mobility === 'true' ? true : false;
        $handicap_sensory_bool = $handicap_sensory === 'true' ? true : false;
        $practice_level = $level === 'false' ? '' : $level;
        $arrondissement = (int)$arrondissement;


        // ------------- step 1 : get all data from the selected practice

        $amount = $facility_repository->getNumberFacilities($practice_id, $handicap_mobility_bool, $handicap_sensory_bool, $practice_level, $arrondissement);
        $amount = $amount ? (int)$amount["amount_facilities"] : 0;
        $practice_data = $practice_repository->getOnePracticeData($practice_id);
        $selected_practice_data = [
            'id' => $practice_id,
            'practice' => $practice_data[0]['practice'],
            'image' => $practice_data[0]['imageName'],
            'facilityAmount' => $amount
        ];

        // --------------- step 2 : get other practices from corresponding sports families.

        $sports_families_id = $family_repository->getAllFamiliesOfAPractice($practice_id);
        $sports_families_practices_id = $practice_repository->getAllPracticesIdForFamilySports($sports_families_id);

        $families_practice_data = [];

        foreach ($sports_families_practices_id as $id) {
            // add the sport to the result if it is not the selected sport
            if ($id !== $practice_id) {
                $amount = $facility_repository->getNumberFacilities($id, $handicap_mobility_bool, $handicap_sensory_bool, $practice_level, $arrondissement);
                $practice_data = $practice_repository->getOnePracticeData($id);
                $families_practice_data = $this->addResult($families_practice_data, $id, $practice_data[0]['practice'], $practice_data[0]['imageName'], (int)$amount['amount_facilities']);
            }
        }

        $response = ['selectedSportData' => $selected_practice_data, 'otherFamilies' => $families_practice_data];
        return new JsonResponse($response);
    }



    private function addResult($array, $id, $practice_name, $practice_image, $facilities_amount) {
        array_push($array, [
            'id' => $id,
            'practice' => $practice_name,
            'image' => $practice_image,
            'facilityAmount' => $facilities_amount
        ]);
        return $array;
    }
}
