<?php

namespace App\Controller;

use App\Repository\SportsFacilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class FacilitiesByArrondissementController extends AbstractController
{
    // return the number of sports facilities for a given sport (id_practice) for each arrondissement

    /**
     * @Route("/facilities-by-arrondissement/{id_practice}", name="facilities_concentration_by_arrondissement")
     * @param SportsFacilityRepository $facility_repository
     * @param $id_practice
     * @return JsonResponse
     */

    public function index(SportsFacilityRepository $facility_repository, $id_practice) :JsonResponse
    {
        // get the number of facilities of arrondissements having sports facilities for the selected sport
        $amount_by_arrondissement = $facility_repository->getNumberOfFacilitiesForEachArrondissement((int)$id_practice);
        $result = [];

        // add the missing arrondissements (those where no facility was found)
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

            // add the missing arrondissement in the result []
            if (!$is_in_array) {
                array_push($result, [
                'arrondissement' => $i,
                'amountFacilities' => 0
                ]);
            }
        }

        return new JsonResponse($result);
    }
}
