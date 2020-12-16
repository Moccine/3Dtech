<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Subscriber;
use App\Form\SubscriberType;
use App\Manager\SubscriberManager;
use App\Repository\FaqRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('front/default/index.html.twig');
    }

    /**
     * @Route("/newsletter", name="newsletter", methods={"GET", "POST"})
     */
    public function newsletter(Request $request, SubscriberManager $subscriberManager, TranslatorInterface $translator): Response
    {
        $subscriber = new Subscriber();

        $form = $this->createForm(SubscriberType::class, $subscriber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subscriberManager->add($subscriber);
            $this->addFlash('success', $translator->trans('app.flash.subscriptionNewsletter'));
        }

        return $this->render('front/default/newsletter.html.twig');
    }

    /**
     * @Route("/faq", name="faq", methods={"GET"})
     */
    public function faq(FaqRepository $faqRepository): Response
    {
        return $this->render('front/default/faq.html.twig', [
            'listFaq' => $faqRepository->findAll(),
        ]);
    }
}
