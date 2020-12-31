<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComputerParkSupervisionController extends AbstractController
{
    /**
     * @Route("/computer/park/supervision", name="computer_park_supervision")
     */
    public function index(): Response
    {
        return $this->render('computer_park_supervision/index.html.twig', [

            'controller_name' => 'ComputerParkSupervisionController',

        ]);
    }
    /**
     * @Route("/computer/park/supervisions", name="computer_park")
     */
    public function pack(): Response
    {
        return $this->render('computer_park_supervision/index.html.twig', [

            'controller_name' => 'ComputerParkSupervisionController',

        ]);
    }
}
