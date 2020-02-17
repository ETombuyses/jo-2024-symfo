<?php

namespace App\Controller;

use App\Repository\SportsFacilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AddressListController extends AbstractController
{
    /**
     * @Route("/address/list/{id_practice}/{handicap_mobility}/{handicap_sensory}/{level}/{arrondissement}", name="address_list")
     */
    public function index(SportsFacilityRepository $facility_repository, $id_practice, $handicap_mobility, $handicap_sensory, $level, $arrondissement = -1)
    {
        $practice_id = (int)$id_practice;
        $handicap_mobility_bool = $handicap_mobility === 'true' ? true : false;
        $handicap_sensory_bool = $handicap_sensory === 'true' ? true : false;
        $practice_level = $level === 'false' ? '' : $level;
        $arrondissement = (int)$arrondissement;



    }
}
