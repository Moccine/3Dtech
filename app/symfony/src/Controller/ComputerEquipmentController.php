<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComputerEquipmentController extends AbstractController
{
    /**
     * @Route("/computer/equipment", name="computer_equipment")
     */
    public function index(): Response
    {
        return $this->render('computer_equipment/index.html.twig', [
            'controller_name' => 'ComputerEquipmentController',
        ]);
    }
}
