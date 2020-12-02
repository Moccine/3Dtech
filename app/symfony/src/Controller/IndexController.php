<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="3dtech_index")
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }
    /**
     * @Route("/partners", name="3dtech_partners")
     */
    public function partners()
    {

        return $this->render('home/partners.html.twig');
    }

    /**
     * @Route("/partners", name="3dtech_clients")
     */
    public function clients()
    {

        return $this->render('home/clients.html.twig');
    }
    /**
     * @Route("/contact", name="3dtech_contact")
     */
    public function contact()
    {

        return $this->render('home/contact.html.twig');
    }

    /**
     * @Route("/engagements", name="3dtech_engagements")
     */
    public function engagements()
    {

        return $this->render('home/engagements.html.twig');
    }
    /**
     * @Route("/hiring", name="3dtech_hiring")
     */
    public function hiring()
    {

        return $this->render('home/hiring.html.twig');
    }
    /**
     * @Route("/jobs", name="3dtech_jobs")
     */
    public function jobs()
    {

        return $this->render('home/jobs.html.twig');
    }
}
