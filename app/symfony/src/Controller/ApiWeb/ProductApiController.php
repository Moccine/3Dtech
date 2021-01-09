<?php


namespace App\Controller\ApiWeb;

use App\Entity\Product;
use App\Entity\Quotation;
use App\Entity\QuotationLine;
use App\Entity\Vat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ProductApiController extends AbstractController
{
    private $session;

    private EntityManagerInterface $em;

    /**
     * ProductApiController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em = $em;
        $this->session = $session;

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
        $quotationId = $ajaxDatas['quotationId'];
        /** @var Vat $vat */
        $vat = $this->em->getRepository(Vat::class)->find((int)$vatVal);
        $quotation = $this->em->getRepository(Quotation::class)->find((int)$quotationId);
        //update all values
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

    /**
     * @Route("/create/new/quotationLine/{id}", name="new_quotationLine")
     * @return JsonResponse
     */
    public function createQuotationAction(Quotation $quotation): JsonResponse
    {
        $quotationLine = new QuotationLine();
        $this->em->persist($quotationLine);
        $quotation->addQuotationLine($quotationLine);
        $this->em->flush();
        $data = [
            'id' => $quotationLine->getId(),
        ];

        return $this->json($data);
    }
    /**
     * @Route("/remove/quotationLine/{id}", name="remove_quotationLine")
     * @return JsonResponse
     */
    public function removeQuotationAction(QuotationLine $quotationLine): JsonResponse
    {
        dump($quotationLine);
        $this->em->remove($quotationLine);
        $this->em->remove($quotationLine);
        $this->em->flush();
        $data = [];

        return $this->json($data);
    }
}
