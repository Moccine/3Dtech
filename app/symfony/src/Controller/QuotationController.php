<?php

namespace App\Controller;

use App\Entity\Quotation;
use App\Service\QuotationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuotationController extends AbstractController
{
    /**
     * @Route("/quotation/{id}", name="generate_invoice")
     */
    public function index(Quotation $quotation, QuotationService $quotationService): Response
    {
       // $quotationService->generateQuotePDF($quotation);
        return @$quotationService->generateQuotePDF($quotation);

       /* return $this->render('quotation/index.html.twig', [
            'controller_name' => 'QuotationController',
        ]);*/
    }
}
