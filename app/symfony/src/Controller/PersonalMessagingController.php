<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonalMessagingController extends AbstractController
{
    /**
     * @Route("/personal/messaging", name="personal_messaging")
     */
    public function index(): Response
    {
        return $this->render('personal_messaging/index.html.twig', [
            'controller_name' => 'PersonalMessagingController',
        ]);
    }
}
