<?php

namespace App\Controller;

use App\Repository\OlympicEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class OlympicEventsOfTheDayController extends AbstractController
{
    // return a list with all olympic sports of a given date
    // used to generate the calendar filter (only displays the olympic sports of a selected date)

    /**
     * @Route("/olympic-events/{date}", name="olympic_events")
     * @param OlympicEventRepository $repository
     * @param $date
     * @return JsonResponse
     */


    public function index(OlympicEventRepository $repository, $date) :JsonResponse
    {
        // get all the olympic sports played on $date
        $practices = $repository->getAllOlympicSportsOfTheDay($date);

        $result = [];

        // format the output result
        foreach ($practices as $practice) {
            array_push($result, [
                'id' => (int)$practice['id'],
                'practice' => $practice['practice'],
                'image' => $practice['imageName']
            ]);
        }

        return new JsonResponse($result);
    }
}
