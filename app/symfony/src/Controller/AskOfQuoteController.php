<?php

namespace App\Controller;

use App\Entity\AskOfQuote;
use App\Form\AskOfQuoteType;
use App\Service\Mailer\Sender;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AskOfQuoteController extends AbstractController
{
    /**
     * @Route("/devis-informatique", name="ask_of_quote")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Sender $sender): Response
    {
        $em = $this->getDoctrine()->getManager();
        $askOfQuote = new AskOfQuote();
        $form = $this->createForm(AskOfQuoteType::class, $askOfQuote);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($askOfQuote);
            $em->flush();
            $to = $askOfQuote->getEmail();
            $subject = 'demande de devis';
            $content = $sender->doTemplate('ask_of_quote/email_confirm.html.twig', ['askOfQuote' => $askOfQuote,]);
            $bindings = [];
            $attachments = null;
            $sender->deliver($to, $subject, $content, $bindings, $attachments);
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
