<?php


namespace App\Controller\ApiWeb;

use App\Entity\Product;
use App\Entity\Quotation;
use App\Entity\QuotationLine;
use App\Entity\Vat;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @Route("/serach/product/{productId}/quotation-line/{quotationLineId}", name="search_product")
     * @param Request $request
     * @param Product $product
     * @param QuotationLine $quotationLine
     * @return JsonResponse
     * @ParamConverter("product", options={"id" = "productId"})
     * @ParamConverter("quotationLine", options={"id" = "quotationLineId"})
     */
    public function calculateQuotationAction(Request $request, Product $product, QuotationLine $quotationLine)
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
        /** @var Quotation $quotation */
        $quotation = $this->em->getRepository(Quotation::class)->find((int)$quotationId);
        //update all values
        $ht = $product->getPrice() * $quantity * (1 - $discountVal / 100);
        $taxe = ($vat instanceof Vat) ? (float)$vat->getTaxe() : 0;
        $amount = $ht * (1 + $taxe);
        // Mettre à jour quotation line
        $quotationLine->setTotalHt($ht)->setVat($vat)
            ->setUnitPrice($product->getPrice())
            ->setAmount($amount)
            ->setDiscount($discountVal)
            ->setQuantity((int)$quantity);
        // Mettre à jour quotation
        $this->updateQuotationPrices($quotation);
        $this->em->flush();
        dump($quotationLine);
        $data = [
            'quotationLineUnitPrice' => (float)$product->getPrice(),
            'quotationLineHt' => (float)$quotationLine->getTotalHt(),
            'quotationLineAmount' => (float)$quotationLine->getAmount(),
            'vat' => $vat->getTaxe(),
            'qquotationLineDiscount' => $quotationLine->getDiscount(),
            'quotationAmount' => $quotation->getAmount(),
            'quotationHt' => $quotation->getTotalHt(),
            //'quotation-discount' => $quotation->getD(),
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

        $this->em->remove($quotationLine);
        $this->em->remove($quotationLine);
        $this->em->flush();
        $quotation = $quotationLine->getQuotation();
        if ($quotation instanceof Quotation) {
            $this->updateQuotationPrices($quotation);
        }
        $this->em->flush();

        $data = [
            'quotationAmount' => $quotation->getAmount(),
            'quotationHt' => $quotation->getTotalHt(),
        ];

        return $this->json($data);
    }

    public function updateQuotationPrices(Quotation $quotation)
    {
        $quotationLines = $quotation->getQuotationLine();
        $totalHt = 0;
        $amount = 0;
        foreach ($quotationLines as $quotationLine) {
            $totalHt += $quotationLine->getTotalHt();
            $amount += $quotationLine->getAmount();
        }
        $quotation->setTotalHt($totalHt);
        $quotation->setAmount($amount);
        $this->em->flush();
    }
}
