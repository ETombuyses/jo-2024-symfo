<?php

namespace App\Controller;

use App\Repository\OlympicEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class ArrondissementOlympicEventController extends AbstractController
{

    // return the current olympic events taking place in a specific arrondissement

    /**
     * @Route("/arrondissement-olympic-event/{arrondissement}/{date}", name="arrondissement_olympic_event")
     * @param OlympicEventRepository $repository
     * @param $arrondissement
     * @param $date
     * @return JsonResponse
     */

    public function index(OlympicEventRepository $repository, $arrondissement, $date) :JsonResponse
    {
        $events = $repository->getArrondissementCurrentEvents((int)$arrondissement, $date);
        return new JsonResponse($events);
    }
}
