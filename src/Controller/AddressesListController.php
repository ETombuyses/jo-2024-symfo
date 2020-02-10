<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AddressesListController extends AbstractController
{
    /**
     * @Route("/addresses/{arrondissement}", name="addresses_list")
     * @param
     * @param $arrondissement
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AddressesListController.php',
        ]);
    }
}
