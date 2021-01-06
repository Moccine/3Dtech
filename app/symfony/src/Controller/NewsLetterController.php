<?php

namespace App\Controller;

use App\Entity\NewsLetter;
use App\Form\NewsLetterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsLetterController extends AbstractController
{
    /**
     * @Route("/news/letter", name="add_news_letter")
     */
    public function addNewEmail(Request $request): Response
    {
        $newLetter = new NewsLetter();
        $newLetterForm = $this->createForm(NewsLetterType::class, $newLetter);
        $newLetterForm->handleRequest($request);
        if ($newLetterForm->isSubmitted() and $newLetterForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newLetter);
            $em->flush();
        }
        return $this->redirectToRoute('3dtech_index');
    }
}
