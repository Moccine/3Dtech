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
        $ajaxDatas = $request->request->get('ajaxData');
        $quantity = (int)$ajaxDatas['quantityVal'] ?? 1;
        $ttcVal = (float)$ajaxDatas['ttcVal'];
        $unitPriceVal = (float)$ajaxDatas['unitPriceVal'];
        $unitPriceVal = (float)$ajaxDatas['unitPriceVal'];
        $discountVal = (float)$ajaxDatas['discountVal'];
        $htVal = (float)$ajaxDatas['htVal'];
        $vat = (float)$ajaxDatas['vatVal'];

        $ht = $product->getPrice() * $quantity*(1 - $discountVal/100);
        $taxe = (float)$vat/100;
        $amount = (float)$ht * (1 + (float)$taxe);

        $data = [
            'name' => $product->getName(),
            'unitPrice' => $product->getPrice(),
            'code' => $product->getCode(),
            'ht' => (float)$ht,
            'ttc' => (float)$amount,
        ];

        return $this->json($data);
    }
}
