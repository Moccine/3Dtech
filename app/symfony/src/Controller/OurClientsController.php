<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OurClientsController extends AbstractController
{
    /**
     * @Route("/our/clients", name="our_clients")
     */
    public function index(): Response
    {
        return $this->render('our_clients/index.html.twig', [
            'controller_name' => 'OurClientsController',
        ]);
    }
}
