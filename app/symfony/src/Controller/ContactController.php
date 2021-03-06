<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Manager\ContactManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, EntityManagerInterface $em, ContactManager $contactManager): Response
    {
        $contact =  new Contact();
        $clear = false;
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
           $contactManager->create($contact);
           $contactManager->sendAskQuoteMail($contact);
            $clear = true;
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'clear' => $clear,
        ]);
    }
}
