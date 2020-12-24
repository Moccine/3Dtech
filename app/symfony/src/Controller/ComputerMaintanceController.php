<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComputerMaintanceController extends AbstractController
{
    /**
     * @Route("/computer/maintance", name="computer_maintance")
     */
    public function index(): Response
    {
        return $this->render('computer_maintance/index.html.twig');
    }
}
