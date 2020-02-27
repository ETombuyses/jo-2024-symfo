<?php

namespace App\Controller;

use App\Repository\SportsPracticeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class LevelFilterController extends AbstractController
{
    // return a list of all existing levels (for the "level" filter)

    /**
     * @Route("/level-filter-values", name="level_filter_values")
     * @param SportsPracticeRepository $repository
     * @return JsonResponse
     */

    public function index(SportsPracticeRepository $repository) :JsonResponse
    {
        $levels = [];
        $levels_list = $repository->getLevelFilters();

        foreach ($levels_list as $result) {
            array_push($levels, $result['practice_level']);
        }
        return new JsonResponse($levels);
    }
}
