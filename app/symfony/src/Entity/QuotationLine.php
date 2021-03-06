<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\QuotationLineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuotationLineRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class QuotationLine
{
    use CreatedAtTrait;
    use UpdatedAtTrait;
    use IdentifiableTrait;


    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $unitPrice;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $discount;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $totalHt;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $amount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity = 1;

    /**
     * @ORM\ManyToOne(targetEntity=Quotation::class, inversedBy="quotationLine")
     */
    private $quotation;

    /**
     * @ORM\ManyToOne(targetEntity=Vat::class)
     */
    private $vat;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=true, unique=false)
     */
    private $product;


    /**
     * QuotationLine constructor.
     * @param $discount
     * @param $totalHt
     * @param $amount
     * @param int $quantity
     */
    public function __construct()
    {
        $this->discount = 0;
        $this->totalHt = 0;
        $this->amount = 0;
        $this->quantity = 0;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(?float $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getTotalHt(): ?float
    {
        return $this->totalHt;
    }

    public function setTotalHt(?float $totalHt): self
    {
        $this->totalHt = $totalHt;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDeposit(): ?float
    {
        return $this->deposit;
    }

    public function setDeposit(?float $deposit): self
    {
        $this->deposit = $deposit;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getQuotation(): ?Quotation
    {
        return $this->quotation;
    }

    public function setQuotation(?Quotation $quotation): self
    {
        $this->quotation = $quotation;

        return $this;
    }

    public function getVat(): ?Vat
    {
        return $this->vat;
    }

    public function setVat(?Vat $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

}
