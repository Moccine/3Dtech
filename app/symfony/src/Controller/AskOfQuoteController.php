<?php

namespace App\Controller;

use App\Entity\AskOfQuote;
use App\Form\AskOfQuoteType;
use App\Manager\AskQuoteManager;
use App\Service\Mailer\Sender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AskOfQuoteController extends AbstractController
{
    /**
     * @Route("/devis-informatique", name="ask_of_quote")
     * @param Request $request
     * @param AskQuoteManager $askQuoteManager
     * @return Response
     */
    public function index(Request $request, AskQuoteManager $askQuoteManager): Response
    {
        $askOfQuote = new AskOfQuote();
        $form = $this->createForm(AskOfQuoteType::class, $askOfQuote);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {

            $askOfQuote = $askQuoteManager->create($askOfQuote);
            $askQuoteManager->sendAskQuoteMail($askOfQuote);

            return $this->redirectToRoute('ask_of_quote_confirm', ['id' => $askOfQuote->getId()]);
        }
        return $this->render('ask_of_quote/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/devis-informatique/confirm/{id}", name="ask_of_quote_confirm")
     * @param Request $request
     * @return Response
     */
    public function confirm(AskOfQuote $askOfQuote): Response
    {
        return $this->render('ask_of_quote/ask_quote_confirm.html.twig', [
            'askOfQuote' => $askOfQuote,
        ]);
    }
}
