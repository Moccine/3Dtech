<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Quotation;
use App\Entity\User;
use App\Form\QuotationType;
use App\Service\QuotationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuotationController extends AbstractController
{
    /**
     * @Route("/quotation/generate/{id}", name="generate_quotation")
     */
    public function index(Quotation $quotation, QuotationService $quotationService): Response
    {
        // $quotationService->generateQuotePDF($quotation);
        return @$quotationService->generateQuotePDF($quotation);
       /* return $this->render('quotation/index.html.twig', [
            'controller_name' => 'QuotationController',
        ]);*/
    }

    /**
     * @Route("/quotation/create", name="create_quotation")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $quotation = new Quotation();
        $form = $this->createForm(QuotationType::class, $quotation);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $quotation->setClient($this->getUser());
            $em->persist($quotation);
            $em->flush();

            return $this->redirectToRoute('edit_quotation', ['id' => $quotation->getId()]);
        }
        return $this->render('quotation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/quotation/edit/{id}", name="edit_quotation")
     * @param Request $request
     * @param Quotation $quotation
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function edit(Request $request, Quotation $quotation, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(QuotationType::class, $quotation);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $client = $em->getRepository(Client::class)->find($this->getUser()->getId());
            $quotation->setClient($client);
            $em->flush();
        }

        return $this->render('quotation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/quotation/list", name="quaotation_list")
     */
    public function list()
    {
        $user = $this->getUser();
        $quotationRepository = $this->getDoctrine()->getRepository(Quotation::class);
        if ($user->hasRole(User::ROLE_ADMIN)) {
            $quotations = $quotationRepository->findAll();
        } else {
            $quotations = $quotationRepository->findBy([
                'user' => $user
            ]);
        }

        return $this->render('quotation/list.html.twig', [
            'quotations' => $quotations,
        ]);
    }

    /**
     * @Route("/quotation/remove/{id}", name="remove_quotation")
     */
    public function remove(Quotation $quotation, EntityManagerInterface $em)
    {
        try {
            $em->remove($quotation);
            $em->flush();
        } catch (\Exception $exception) {
            dd($exception);
            return $exception->getMessage();
        }
        return $this->redirectToRoute('quaotation_list');
    }
    /**
     * @Route("/quotation/view/{id}", name="view_quotation")
     */
    public function view(Quotation $quotation, EntityManagerInterface $em)
    {
        dump($quotation);
        return $this->render('quotation/index.html.twig', ['quotation' => $quotation]);
    }
}
