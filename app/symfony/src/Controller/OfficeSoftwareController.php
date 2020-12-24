<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OfficeSoftwareController extends AbstractController
{
    /**
     * @Route("/office/software", name="office_software")
     */
    public function index(): Response
    {
        return $this->render('office_software/index.html.twig');
    }
}
