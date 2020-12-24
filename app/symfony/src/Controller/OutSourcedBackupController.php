<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OutSourcedBackupController extends AbstractController
{
    /**
     * @Route("/out/sourced/backup", name="out_sourced_backup")
     */
    public function index(): Response
    {
        return $this->render('out_sourced_backup/index.html.twig');
    }
}
