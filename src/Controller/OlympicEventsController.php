<?php

namespace App\Controller;

use App\Repository\OlympicEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

// return a list with all olympic sports of the day

class OlympicEventsController extends AbstractController
{
    /**
     * @Route("/olympiceventsbydate/{date}", name="olympic_events")
     * @param OlympicEventRepository $repository
     * @return JsonResponse
     */

    public function index(OlympicEventRepository $repository, $date)
    {
        $practices = $repository->getAll($date);

        $response = new JsonResponse($practices);
        return $response;
    }
}
