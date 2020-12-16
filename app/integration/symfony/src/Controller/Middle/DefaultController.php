<?php

declare(strict_types=1);

namespace App\Controller\Middle;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/middle", name="middle_home", methods={"GET", "POST"})
     */
    public function registration(): Response
    {
        return $this->render('middle/index.html.twig');
    }
}
