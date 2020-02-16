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

        $result = [];

        foreach ($practices as $practice) {
            array_push($result, [
                'id' => (int)$practice['id'],
                'practice' => $practice['practice'],
                'image' => $practice['image_name']
            ]);
        }

        $response = new JsonResponse($result);
        return $response;
    }
}
