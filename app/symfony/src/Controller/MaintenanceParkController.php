<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaintenanceParkController extends AbstractController
{
    /**
     * @Route("/maintenance/park", name="maintenance_park")
     */
    public function index(): Response
    {
        return $this->render('maintenance_park/index.html.twig', [
            'controller_name' => 'MaintenanceParkController',
        ]);
    }
}
