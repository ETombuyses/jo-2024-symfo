<?php

namespace App\Controller;

use App\Repository\SportsFacilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AddressesController extends AbstractController
{

    // return the list of all sports facilities addresses where we can practice a certain sport (id_practice).
    // also returns for each facility the different handicap accesses they have
    // the results are filtered by 4 possible filters : handicap mobility, handicap sensory, level and arrondissement

    /**
     * @Route("/addresses/{id_practice}/{handicap_mobility}/{handicap_sensory}/{level}/{arrondissement}", name="addresses")
     * @param SportsFacilityRepository $facility_repository
     * @param $id_practice
     * @param $handicap_mobility
     * @param $handicap_sensory
     * @param $level
     * @param $arrondissement
     * @return JsonResponse
     */

    public function index(SportsFacilityRepository $facility_repository, $id_practice, $handicap_mobility, $handicap_sensory, $level, $arrondissement = -1) :JsonResponse
    {
        // transform parameters to boolean (handicaps) or to empty value (level) if necessary
        $handicap_mobility_bool = $handicap_mobility === 'true' ? true : false;
        $handicap_sensory_bool = $handicap_sensory === 'true' ? true : false;
        $practice_level = $level === 'false' ? '' : $level;

        $address_list = $facility_repository->getAddresses((int)$id_practice, $handicap_mobility_bool, $handicap_sensory_bool, $practice_level, (int)$arrondissement);
        $result = [];

        foreach ($address_list as $address) {
            // convert 0 and 1 to boolean
            $handi_m_area = (int)$address['handicap_access_mobility_sport_area'] === 0 ? false : true;
            $handi_s_area = (int)$address['handicap_access_sensory_sport_area'] === 0 ? false : true;
            $handi_s_locker = (int)$address['handicap_access_sensory_locker_room'] === 0 ? false : true;
            $handi_m_locker = (int)$address['handicap_access_mobility_locker_room'] === 0 ? false : true;
            $handi_m_swim = (int)$address['handicap_access_mobility_swimming_pool'] === 0 ? false : true;
            $handi_s_sanitary = (int)$address['handicap_access_sensory_sanitary'] === 0 ? false : true;
            $handi_m_sanitary = (int)$address['handicap_access_mobility_sanitary'] === 0 ? false : true;

            // format the final result and push each formated address into the result []
            array_push($result, [
                'facilityType' => $address['facility_type'],
                'facilityName' => $address['facility_name'],
                'addressNumber' => (int)$address['address_number'],
                'addressStreet' => $address['address_street'],
                'arrondissement' => (int)$address['postal_code'],
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
    }
}
