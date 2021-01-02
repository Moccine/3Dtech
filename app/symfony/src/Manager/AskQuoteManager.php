<?php


namespace App\Manager;


use App\Entity\AskOfQuote;
use App\Service\Mailer\Sender;
use Doctrine\ORM\EntityManagerInterface;

class AskQuoteManager
{
    private EntityManagerInterface $em;
    private Sender $sender;

    public function __construct(EntityManagerInterface $entityManager, Sender $sender)
    {
        $this->em = $entityManager;
        $this->sender = $sender;
    }
    public function create(AskOfQuote $askOfQuote){
        $askOfQuote->setUpdatedAt(new \DateTime());
        $this->em->persist($askOfQuote);
        $this->em->flush();

        return $askOfQuote;
    }

    public function sendAskQuoteMail(AskOfQuote  $askOfQuote){
        $to = $askOfQuote->getEmail();
        $subject = 'Demande de devis';
        $content = $this->sender->doTemplate('ask_of_quote/email_confirm.html.twig', ['askOfQuote' => $askOfQuote,]);
        $bindings = [];
        $attachments = null;
        $this->sender->deliver($to, $subject, $content, $bindings, $attachments);
    }

}