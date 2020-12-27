<?php


namespace App\Controller\ApiWeb;


use App\Entity\Product;
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
    public function calculateQuotationAction(Request $request, Product $product ){

        $quantity = $request->request->get('quantity')??1;
        $data = [
            'name' => $product->getName(),
            'unitPrice' => $product->getPrice(),
            'code' => $product->getCode(),
            'ht' =>  $product->getPrice() * $quantity,
            'ttc' => $product->getPrice() * $quantity*(1 + 0.2)
        ];

        return $this->json($data);
    }

}