<?php

namespace App\Controller;

use App\Repository\SportsFacilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AddressListController extends AbstractController
{
    /**
     * @Route("/address/list/{id_practice}/{handicap_mobility}/{handicap_sensory}/{level}/{arrondissement}", name="address_list")
     * @param SportsFacilityRepository $facility_repository
     * @param $id_practice
     * @param $handicap_mobility
     * @param $handicap_sensory
     * @param $level
     * @param int $arrondissement
     * @return JsonResponse
     */
    public function index(SportsFacilityRepository $facility_repository, $id_practice, $handicap_mobility, $handicap_sensory, $level, $arrondissement = -1)
    {
        $practice_id = (int)$id_practice;
        $handicap_mobility_bool = $handicap_mobility === 'true' ? true : false;
        $handicap_sensory_bool = $handicap_sensory === 'true' ? true : false;
        $practice_level = $level === 'false' ? '' : $level;
        $arrondissement = (int)$arrondissement;

        $address_list = $facility_repository->getAddresses($practice_id, $handicap_mobility_bool, $handicap_sensory_bool, $practice_level, $arrondissement);

        if (!$address_list) return new JsonResponse(false);
        $result = [];

        // TODO : peut être remplacer le insee code par code postal --> dans la bdd remplacer kmsquare par code postal


        foreach ($address_list as $address) {

            $handi_m_area = (int)$address['handicap_access_mobility_sport_area'] === 0 ? false : true;
            $handi_s_area = (int)$address['handicap_access_sensory_sport_area'] === 0 ? false : true;
            $handi_s_locker = (int)$address['handicap_access_sensory_locker_room'] === 0 ? false : true;
            $handi_m_locker = (int)$address['handicap_access_mobility_locker_room'] === 0 ? false : true;
            $handi_m_swim = (int)$address['handicap_access_mobility_swimming_pool'] === 0 ? false : true;
            $handi_s_sanitary = (int)$address['handicap_access_sensory_sanitary'] === 0 ? false : true;
            $handi_m_sanitary = (int)$address['handicap_access_mobility_sanitary'] === 0 ? false : true;


            array_push($result, [
                'facilityType' => $address['facility_type'],
                'facilityName' => $address['facility_name'],
                'addressNumber' => (int)$address['address_number'],
                'addressStreet' => $address['address_street'],
                'arrondissement' => (int)$address['insee_code'],
                'handicapAccessMobilitySportArea' => $handi_m_area,
                'handicapAccessSensorySportArea' => $handi_s_area,
                'handicapAccessSensoryLockerRoom' => $handi_s_locker,
                'handicapAccessMobilityLockerRoom' => $handi_m_locker,
                'handicapAccessMobilitySwimmingPool' => $handi_m_swim,
                'handicapAccessSensorySanitary' => $handi_s_sanitary,
                'handicapAccessMobilitySanitary' => $handi_m_sanitary,
            ]);
        }

        return new JsonResponse($result);

// sports aquatiques        2801, 2803, 2804, 5201, 5202, 5204, 5205, 5206, 5208, 601, 6902, 8501, 9405


    }
}
