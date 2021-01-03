<?php


namespace App\Manager;


use App\Entity\Contact;
use App\Service\Mailer\Sender;
use Doctrine\ORM\EntityManagerInterface;

class ContactManager
{
    private EntityManagerInterface $em;
    private Sender $sender;

    public function __construct(EntityManagerInterface $entityManager, Sender $sender)
    {
        $this->em = $entityManager;
        $this->sender = $sender;
    }
    public function create(Contact $contact){
        $contact->setCreatedAt(new \DateTime());
        $this->em->persist($contact);
        $this->em->flush();

        return $contact;
    }

    public function sendAskQuoteMail(Contact $contact){
        $to =  $contact->getEmail();
        $subject = 'Contact via formulaire';
        $content = $this->sender->doTemplate('contact/contact_confirm.html.twig', ['contact' => $contact,]);
        $bindings = [];
        $attachments = null;
        $this->sender->deliver($to, $subject, $content, $bindings, $attachments);
    }
}