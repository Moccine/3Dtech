<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Repository\InvoiceRepository;
use App\Entity\Client;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="InvoiceRepository::class")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable()
 */
class Invoice
{
    use IdentifiableTrait;

    public const STATUS_EDITION = 'EDITION';
    public const STATUS_ARCHIVED = 'ARCHIVED';
    public const INVOICE_STATUS = [
        self::STATUS_EDITION => 'invoice.status.edition',
        self::STATUS_ARCHIVED => 'invoice.status.archived',
    ];

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private DateTime $billingDate;

    /***
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $invoiceName;

    /**
     * @var File
     *
     * @Assert\File(
     *     mimeTypes = {"application/pdf"}
     * )
     * @Vich\UploadableField(mapping="invoice", fileNameProperty="invoiceName")
     */
    private $invoiceFile;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     */
    private ?string $comment;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private string $status;

    /**
     * @var float
     * @ORM\Column(type="float", precision=10, scale=2, nullable=true)
     */
    private float $displacementsCost;

    /**
     * @var float
     * @ORM\Column(type="float", precision=10, scale=2, nullable=true)
     */
    private float $totalHT = 0;

    /**
     * @var float
     * @ORM\Column(type="float", precision=10, scale=2, nullable=true)
     */
    private float $discount = 0;

    /**
     * @var float
     * @ORM\Column(type="float", precision=10, scale=2, nullable=true)
     */
    private float $amount = 0;

    /**
     * @var float
     * @ORM\Column(type="float", precision=10, scale=2, nullable=true)
     */
    private float $VAT = 0.2;

    /**
     * @ORM\Column(type="float", precision=10, scale=2, nullable=true)
     */
    private float $totalTTC = 0;


    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private int $invoiceNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private string $orderNumber;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private float $invoiceSize;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $invoiceUrl;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private bool $locked;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->locked = false;
    }

    public function getBillingDate(): DateTime
    {
        return $this->billingDate;
    }

    public function setBillingDate(DateTime $billingDate): self
    {
        $this->billingDate = $billingDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInvoiceName(): ?string
    {
        return $this->invoiceName;
    }

    public function setInvoiceName(?string $invoiceName): self
    {
        $this->invoiceName = $invoiceName;

        return $this;
    }

    public function getInvoiceFile(): File
    {
        return $this->invoiceFile;
    }

    public function setInvoiceFile(File $invoiceFile): self
    {
        $this->invoiceFile = $invoiceFile;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDisplacementsCost(): float
    {
        return $this->displacementsCost;
    }

    public function setDisplacementsCost(float $displacementsCost): self
    {
        $this->displacementsCost = $displacementsCost;

        return $this;
    }

    public function getTotalHT(): float|int
    {
        return $this->totalHT;
    }

    public function setTotalHT(float|int $totalHT): self
    {
        $this->totalHT = $totalHT;

        return $this;
    }

    public function getDiscount(): float
    {
        return $this->discount;
    }

    public function setDiscount(float|int $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getVAT(): float
    {
        return $this->VAT;
    }

    public function setVAT(float $VAT): self
    {
        $this->VAT = $VAT;
    }

    public function getTotalTTC(): float
    {
        return $this->totalTTC;
    }

    public function setTotalTTC(float|int $totalTTC): self
    {
        $this->totalTTC = $totalTTC;

        return $this;
    }

    /**
     * @return int
     */
    public function getInvoiceNumber(): int
    {
        return $this->invoiceNumber;
    }

    public function setInvoiceNumber(int $invoiceNumber): self
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): self
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    /**
     * @return float
     */
    public function getInvoiceSize(): float
    {
        return $this->invoiceSize;
    }

    /**
     * @param float $invoiceSize
     */
    public function setInvoiceSize(float $invoiceSize): void
    {
        $this->invoiceSize = $invoiceSize;
    }

    /**
     * @return string
     */
    public function getInvoiceUrl(): string
    {
        return $this->invoiceUrl;
    }

    /**
     * @param string $invoiceUrl
     */
    public function setInvoiceUrl(string $invoiceUrl): void
    {
        $this->invoiceUrl = $invoiceUrl;
    }

    /**
     * @return bool
     */
    public function isLocked(): bool
    {
        return $this->locked;
    }

    /**
     * @param bool $locked
     */
    public function setLocked(bool $locked): void
    {
        $this->locked = $locked;
    }

}
