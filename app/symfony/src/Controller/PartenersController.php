<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartenersController extends AbstractController
{
    /**
     * @Route("/parteners", name="parteners")
     */
    public function index(): Response
    {
        return $this->render('parteners/index.html.twig', [
            'controller_name' => 'PartenersController',
        ]);
    }
}
