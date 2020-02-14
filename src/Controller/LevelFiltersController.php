<?php

namespace App\Controller;

use App\Repository\SportsPracticeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

// return a list of all the existing filters (level)

class LevelFiltersController extends AbstractController
{
    /**
     * @Route("/levelfilters", name="level_filters")
     * @param SportsPracticeRepository $repository
     * @return JsonResponse
     */
    public function index(SportsPracticeRepository $repository)
    {
        $response = $repository->getLevelFilters();
        return $response;
    }
}
