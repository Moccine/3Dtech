<?php

namespace App\Controller;

use App\Entity\SlideShow;
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
        $em = $this->getDoctrine()->getManager();
        /** @var SlideShow $slideShow */

        return $this->render('home/index.html.twig', [
            'slideShow' => '',
        ]);
    }
    /**
     * @Route("/partners", name="3dtech_partners")
     */
    public function partners()
    {

        return $this->render('home/partners.html.twig');
    }
}
