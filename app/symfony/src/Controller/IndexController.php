<?php

namespace App\Controller;

use App\Entity\NewsLetter;
use App\Entity\SlideShow;
use App\Entity\User;
use App\Form\NewsLetterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="3dtech_index")
     */
    public function index(Request $request)
    {
        $newLetter = new NewsLetter();
        $newLetterForm = $this->createForm(NewsLetterType::class, $newLetter);
        $newLetterForm->handleRequest($request);
        if ($newLetterForm->isSubmitted() and $newLetterForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newLetter);
            $em->flush();
        }
        return $this->render('home/index.html.twig', [
            'slideShow' => '',
            'form' => $newLetterForm->createView(),
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
