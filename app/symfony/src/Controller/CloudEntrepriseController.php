<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CloudEntrepriseController extends AbstractController
{
    /**
     * @Route("/cloud/entreprise", name="cloud_entreprise")
     */
    public function index(): Response
    {
        return $this->render('cloud_entreprise/index.html.twig', [
            'controller_name' => 'CloudEntrepriseController',
        ]);
    }
}
