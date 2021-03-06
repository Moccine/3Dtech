<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\CodifiableTrait;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ProductRepository;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository", repositoryClass=ProductRepository::class)
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Product
{
    use CreatedAtTrait;
    use UpdatedAtTrait;
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
     * @Assert\NotBlank()
     */
    private ?string $name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Assert\NotBlank()
     */
    private float $price;

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
        return sprintf('%s', $this->category->getName());
    }
}
