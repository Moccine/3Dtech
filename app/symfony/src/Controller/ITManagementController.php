<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ITManagementController extends AbstractController
{
    /**
     * @Route("/it_management", name="it_management")
     */
    public function index(): Response
    {
        return $this->render('it_management/index.html.twig', [
            'controller_name' => 'ITManagementController',
        ]);
    }
}
