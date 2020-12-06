<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItNetWorkSecurityController extends AbstractController
{
    /**
     * @Route("/it/net/work/security", name="it_net_work_security")
     */
    public function index(): Response
    {
        return $this->render('it_net_work_security/index.html.twig', [
            'controller_name' => 'ItNetWorkSecurityController',
        ]);
    }
}
