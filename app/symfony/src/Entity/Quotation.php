<?php

namespace App\Entity;

use App\Entity\Traits\AddressTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Repository\QuotationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuotationRepository::class)
 */
class Quotation
{
    use IdentifiableTrait;
    //use AddressTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="text", nullable=true, length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private \DateTime $quotationDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $reference;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $payment;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $address;
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $amount;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $totalHt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $quantity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $designation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private bool $status = false;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $deposit;

    /**
     * @ORM\OneToOne(targetEntity=Deadlines::class, cascade={"persist", "remove"})
     */
    private $deadline;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private \DateTime $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private \DateTime $endDate;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="quotation")
     */
    private $client;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class)
     */
    private $products;


    public function __construct()
    {
        $this->quotationDate = new \DateTime();
        $this->amount = 0;
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQuotationDate(): ?\DateTime
    {
        return $this->quotationDate;
    }

    public function setQuotationDate(\DateTime $quotationDate): self
    {
        $this->quotationDate = $quotationDate;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getPayment(): ?string
    {
        return $this->payment;
    }

    public function setPayment(?string $payment): self
    {
        $this->payment = $payment;

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

    public function getTotalHt(): ?float
    {
        return $this->totalHt;
    }

    public function setTotalHt(?float $totalHt): self
    {
        $this->totalHt = $totalHt;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

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

    public function getDeadline(): ?Deadlines
    {
        return $this->deadline;
    }

    public function setDeadline(?Deadlines $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     * @return Quotation
     */
    public function setAddress(?string $address): self
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }

}
