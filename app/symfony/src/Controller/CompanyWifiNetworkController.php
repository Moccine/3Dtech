<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyWifiNetworkController extends AbstractController
{
    /**
     * @Route("/company/wifi/network", name="company_wifi_network")
     */
    public function index(): Response
    {
        return $this->render('company_wifi_network/index.html.twig', [
            'controller_name' => 'CompanyWifiNetworkController',
        ]);
    }
}
