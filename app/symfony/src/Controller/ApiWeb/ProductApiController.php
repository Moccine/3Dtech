<?php


namespace App\Controller\ApiWeb;

use App\Entity\Product;
use App\Entity\Vat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductApiController extends AbstractController
{
    /**
     * @Route("/serach/{id}", name="search_product")
     * @return JsonResponse
     */
    public function calculateQuotationAction(Request $request, Product $product)
    {
        $quantity = $request->request->get('quantity') ?? 1;
        $ht = number_format((float)($product->getPrice() * $quantity), 2, '.', ' ');
        $taxe = ($product->getVat() instanceOf Vat) ? $product->getVat()->getTaxe() : Vat::DEFAULT_VAT;
        $amount = (float)$ht * (1 + (float)$taxe);
        $data = [
            'name' => $product->getName(),
            'unitPrice' => $product->getPrice(),
            'code' => $product->getCode(),
            'ht' => (float)$ht,
            'ttc' => (float)number_format($amount, 2, '.', ' '),
        ];

        return $this->json($data);
    }
}
