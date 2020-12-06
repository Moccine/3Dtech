<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OurJobsController extends AbstractController
{
    /**
     * @Route("/our/jobs", name="our_jobs")
     */
    public function index(): Response
    {
        return $this->render('our_jobs/index.html.twig', [
            'controller_name' => 'OurJobsController',
        ]);
    }
}
