<?php

namespace App\Controller;

use App\Entity\Quotation;
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
        //  return @$quotationService->generateQuotePDF($quotation);

        return $this->render('quotation/index.html.twig', [
            'controller_name' => 'QuotationController',
        ]);
    }

    /**
     * @Route("/quotation/create", name="create_quotation")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $quotation = new Quotation();

        $form = $this->createForm(QuotationType::class, $quotation);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $em->persist($quotation);
            dd($quotation);
        }
        return $this->render('quotation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
