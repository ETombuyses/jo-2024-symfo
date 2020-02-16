<?php

namespace App\Controller;

use App\Repository\ArrondissementRepository;
use App\Repository\SportsFacilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

// data to generate the colors of the map

class FacilityByArrondissementController extends AbstractController
{
    /**
     * @Route("/facility/by/arrondissement/{id_practice}", name="facility_concentration_by_arrondissement")
     * @param SportsFacilityRepository $facility_repository
     * @param $id_practice
     * @return JsonResponse
     */
    public function index(SportsFacilityRepository $facility_repository, $id_practice)
    {

        $amount_by_arrondissement = $facility_repository->getAmountFacilitiesForEachArrondissement($id_practice);

        $result = [];



        for ($i = 1; $i < 21; $i++) {
            $is_in_array = false;

            foreach ($amount_by_arrondissement as $arrondissement) {
                if ((int)$arrondissement['id_arrondissement'] === $i) {
                    array_push($result, [
                        'arrondissement' => (int)$arrondissement['id_arrondissement'],
                        'amountFacilities' => (int)$arrondissement['amount_facilities']
                    ]);
                    $is_in_array = true;
                }
            }

            if (!$is_in_array) {
                array_push($result, [
                'arrondissement' => $i,
                'amountFacilities' => 0
                ]);
            }
        }

//        foreach ($amount_by_arrondissement as $arrondissement) {
//            array_push($result, [
//                'arrondissement' => (int)$arrondissement['id_arrondissement'],
//                'amountFacilities' => $arrondissement['amount_facilities']
//            ]);
//        }


        $response = new JsonResponse($result);
        return $response;
    }
}
