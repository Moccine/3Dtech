<?php


namespace App\Controller\ApiWeb;

use App\Entity\Product;
use App\Entity\Vat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductApiController extends AbstractController
{
    private EntityManagerInterface $em;

    /**
     * ProductApiController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

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
        $discountVal = (float)$ajaxDatas['discountVal'] ?? 0;
        $htVal = (float)$ajaxDatas['htVal'];
        $vatVal = $ajaxDatas['vatVal'];
        /** @var Vat $vat */
        $vat = $this->em->getRepository(Vat::class)->find((int)$vatVal);
        $ht = $product->getPrice() * $quantity * (1 - $discountVal / 100);
        $taxe = ($vat instanceof Vat) ? (float)$vat->getTaxe() : 0;
        $amount = $ht * (1 + $taxe);

        $data = [
            'name' => $product->getName(),
            'unitPrice' => (float)$product->getPrice(),
            'code' => $product->getCode(),
            'ht' => (float)$ht,
            'ttc' => (float)$amount,
            'vat' => $taxe,
            'discount' => $discountVal,
            ];

        return $this->json($data);
    }
}
