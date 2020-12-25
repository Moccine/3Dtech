<?php

namespace App\Controller;

use App\Entity\SlideShow;
use App\Entity\User;
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
        $user = new User();
        $em->persist($user->setEmail('test66@gmail.com')->setPassword('rrr'));
        $em->flush();
        dd($user);
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
