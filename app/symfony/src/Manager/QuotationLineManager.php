<?php


namespace App\Manager;


use App\Entity\Product;
use App\Entity\QuotationLine;

class QuotationLineManager
{

    public function getProductTotalHt(QuotationLine $quotationLine)
    {
        /** @var Product $product */
        $product = $quotationLine->getProduct()->first();
        $vat = (float)$quotationLine->getVat()->getTaxe() / 100;
        $totalHt = (float)($quotationLine->getQuantity() * $product->getPrice() - $quotationLine->getDiscount() / 100);
        $amount = $totalHt * (1 + $vat);
        $quotationLine->setTotalHt($totalHt)->setAmount($amount);

        return $$quotationLine;

    }
}