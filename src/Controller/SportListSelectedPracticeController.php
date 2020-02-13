<?php

namespace App\Controller;

use App\Entity\SportsPractice;
use App\Repository\SportsFacilityRepository;
use App\Repository\SportsFamilyRepository;
use App\Repository\SportsPracticeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SportListSelectedPracticeController extends AbstractController
{
    /**
     * @Route("/sport/list/selected/practice/{id_practice}/{handicap_mobility}/{handicap_sensory}/{level}", name="sport_list_selected_practice")
     * @param SportsFacilityRepository $facility_repository
     * @param SportsPracticeRepository $practice_repository
     * @param SportsFamilyRepository $family_repository
     * @param $id_practice
     * @param $handicap_mobility
     * @param $handicap_sensory
     * @param $level
     * @return JsonResponse
     */
    public function index(SportsFacilityRepository $facility_repository, SportsPracticeRepository $practice_repository, SportsFamilyRepository $family_repository, $id_practice, $handicap_mobility, $handicap_sensory, $level)
    {
        // ------------- step 1 : get all data from the selected practice
        $practice_id = (int)$id_practice;
        $handicap_mobility_bool = $handicap_mobility === 'true' ? true : false;
        $handicap_sensory_bool = $handicap_sensory === 'true' ? true : false;
        // TODO : find how to make a parameter optional (not make a second route because it is the same code, only the param changes
        $practice_level = $level === 'false' ? '' : $level;


        $amount = $facility_repository->getAmountFacilities($practice_id, $handicap_mobility_bool, $handicap_sensory_bool, $practice_level);

        $practice_data = $practice_repository->getOnePracticeData($practice_id);

        $selected_practice_data = [
            'id' => $practice_id,
            'practice' => $practice_data[0]['practice'],
            'image' => $practice_data[0]['image_name'],
            'facilityAmount' => $amount['amount_facilities']
        ];



        // --------------- step 2 : get other practices from corresponding sports families.

        $sports_families_id = $family_repository->getAllFamiliesOfAPractice($practice_id);

        $sports_families_practices_id = $practice_repository->getAllPracticesIdForFamilySports($sports_families_id);

        $families_practice_data = [];

        foreach ($sports_families_practices_id as $id) {
            if ($id !== $practice_id) {
                $amount = $facility_repository->getAmountFacilities($id, $handicap_mobility_bool, $handicap_sensory_bool, $practice_level);

                $practice_data = $practice_repository->getOnePracticeData($id);

                $selected_practice_data_family = [
                    'id' => $id,
                    'practice' => $practice_data[0]['practice'],
                    'image' => $practice_data[0]['image_name'],
                    'facilityAmount' => $amount['amount_facilities']
                ];

                array_push($families_practice_data, $selected_practice_data_family);
            }
        }

        $response = ['selectedSportData' => $selected_practice_data, 'otherFamilies' => $families_practice_data];


        return new JsonResponse($response);

        // TODO: (normalement c'est ok) revoir la logique car c'est bizarre d'avoir de la course quand on choisi la natation (famille en commun = pentathlon)
        // idee: exclure le triathlon et pentathlon de la liste ? seulement si autres familles dans la list
    }
}
