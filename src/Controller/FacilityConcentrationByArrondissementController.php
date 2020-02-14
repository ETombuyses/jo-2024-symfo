<?php

namespace App\Controller;

use App\Repository\ArrondissementRepository;
use App\Repository\SportsFacilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

// data to generate the colors of the map

class FacilityConcentrationByArrondissementController extends AbstractController
{
    /**
     * @Route("/facility/concentration/by/arrondissement/{id_practice}/{handicap_mobility}/{handicap_sensory}/{level}", name="facility_concentration_by_arrondissement")
     * @param ArrondissementRepository $arrondissement_repository
     * @param SportsFacilityRepository $facility_repository
     * @param $id_practice
     * @param $handicap_mobility
     * @param $handicap_sensory
     * @param string $level
     * @return JsonResponse
     */
    public function index(ArrondissementRepository $arrondissement_repository, SportsFacilityRepository $facility_repository, $id_practice, $handicap_mobility, $handicap_sensory, $level = '')
    {
        $handicap_mobility_bool = $handicap_mobility === 'true' ? true : false;
        $handicap_sensory_bool = $handicap_sensory === 'true' ? true : false;

        $amount_and_surface_by_arrondissement = $facility_repository->getAmountFacilitiesForEachArrondissement($id_practice, $handicap_mobility_bool, $handicap_sensory_bool, $level);

        $result = [];

        if (!$amount_and_surface_by_arrondissement) {
            return new JsonResponse('no facility matching this request');
        }
        foreach ($amount_and_surface_by_arrondissement as $arrondissement) {
            // TODO : ne laisser que le nombre ou la concentration après quand on aura choisi lequel utiliser
            // si km2 --> représente le fait qu'il y en ait beaucoup ou pas dans l'arrondissement par rapport à sa taille
            // (facilité de trouver un établiseement est plus élevé car y en a plus par km)

            $facilities_by_km_square = $arrondissement['amount_facilities'] / $arrondissement['surface_km_square'];
            $facilities_by_km_square = round($facilities_by_km_square, 2);


            array_push($result, [
                'arrondissement' => (int)$arrondissement['id_arrondissement'],
                'facilities_by_km_square' => $facilities_by_km_square,
                'amountFacilities' => $arrondissement['amount_facilities']
            ]);
        }



        $response = new JsonResponse($result);
        return $response;

    }
}
