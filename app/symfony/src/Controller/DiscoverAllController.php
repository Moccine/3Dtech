<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiscoverAllController extends AbstractController
{
    /**
     * @Route("/discover/all", name="discover_all")
     */
    public function index(): Response
    {
        return $this->render('discover_all/index.html.twig');
    }
}
