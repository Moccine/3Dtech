<?php

namespace App\Controller;

use App\Entity\AskOfQuote;
use App\Form\AskOfQuoteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AskOfQuoteController extends AbstractController
{
    /**
     * @Route("/devis-informatique", name="ask_of_quote")
     */
    public function index(): Response
    {
        $form = $this->createForm(AskOfQuoteType::class, new AskOfQuote());
        return $this->render('ask_of_quote/index.html.twig', [
            'controller_name' => 'AskOfQuoteController',
            'form' => $form->createView()
        ]);
    }
}
