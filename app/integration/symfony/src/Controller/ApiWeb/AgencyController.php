<?php

declare(strict_types=1);

namespace App\Controller\ApiWeb;

use App\Entity\Agency;
use App\Manager\OperatorManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AgencyController extends AbstractController
{
    /**
     * @Route("/agency/operator/update/{id}", name="agency_operator_update", methods={"GET", "POST"})
     */
    public function index(Agency $agency, OperatorManager $operatorManager)
    {
        $operatorManager->updateAgency($this->getUser(), $agency);
    }
}
