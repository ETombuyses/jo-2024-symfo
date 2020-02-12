<?php

namespace App\Controller;

use App\Repository\OlympicEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OlympicEventsController extends AbstractController
{
    /**
     * @Route("/olympiceventsbydate", name="olympic_events")
     */
    public function index(OlympicEventRepository $repository)
    {
        $response = $repository->getAll();
        return $response;
    }
}
