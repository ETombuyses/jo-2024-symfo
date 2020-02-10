<?php

namespace App\Controller;

use App\Repository\SportsFacilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class FacilitiesConcentrationController extends AbstractController
{
    /**
     * @Route("/facilitiesconcentration", name="facilities_concentration")
     * @param SportsFacilityRepository $facilities
     * @return JsonResponse
     */
    public function index(SportsFacilityRepository $facilities)
    {
        $result = $facilities->getAll();
        return $result;
    }

    /**
     * @Route("/facilitiesconcentration/{id_practice}", name="facilities_concentration")
     * @param SportsFacilityRepository $facilities
     * @param $id_practice
     * @return mixed
     */
    public function indexId(SportsFacilityRepository $facilities, $id_practice)
    {
        $result = $facilities->getAllConcentrationForSelectedPractice($id_practice);
        return $result;
    }
}
