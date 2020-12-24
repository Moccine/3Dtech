<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InternetProAccessController extends AbstractController
{
    /**
     * @Route("/internet/pro/access", name="internet_pro_access")
     */
    public function index(): Response
    {
        return $this->render('internet_pro_access/index.html.twig');
    }
}
