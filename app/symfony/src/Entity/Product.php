<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\CodifiableTrait;
use App\Entity\Traits\IdentifiableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ProductRepository;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository", repositoryClass=ProductRepository::class)
 */
class Product
{
    use IdentifiableTrait;
    use CodifiableTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private Category $category;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="float", nullable=true, scale=2)
     */
    private float $price;

    /**
     * @ORM\ManyToOne(targetEntity=Quotation::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quotation;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return int|string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return Product
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
    public function __toString(): string
    {
        return $this->name;
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
}
