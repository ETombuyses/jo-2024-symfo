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
     * @Route("/facility/concentration/by/arrondissement/{id_practice}", name="facility_concentration_by_arrondissement")
     * @param SportsFacilityRepository $facility_repository
     * @param $id_practice
     * @return JsonResponse
     */
    public function index(SportsFacilityRepository $facility_repository, $id_practice)
    {

        $amount_by_arrondissement = $facility_repository->getAmountFacilitiesForEachArrondissement($id_practice);

        $result = [];

        if (!$amount_by_arrondissement) {
            return new JsonResponse(false);
        }


        foreach ($amount_by_arrondissement as $arrondissement) {
            array_push($result, [
                'arrondissement' => (int)$arrondissement['id_arrondissement'],
                'amountFacilities' => $arrondissement['amount_facilities']
            ]);
        }


        $response = new JsonResponse($result);
        return $response;
    }
}
