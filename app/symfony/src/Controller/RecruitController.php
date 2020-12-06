<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecruitController extends AbstractController
{
    /**
     * @Route("/recriut", name="recruit")
     */
    public function index(): Response
    {
        return $this->render('recriut/index.html.twig', [
            'controller_name' => 'RecriutController',
        ]);
    }
}
