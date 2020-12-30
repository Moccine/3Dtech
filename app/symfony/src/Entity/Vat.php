<?php

namespace App\Entity;

use App\Repository\VatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VatRepository::class)
 */
class Vat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $taxe;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $name;


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

    /**
     * @return mixed
     */
    public function getTaxe(): float
    {
        return $this->taxe;
    }

    /**
     * @param mixed $taxe
     * @return Vat
     */
    public function setTaxe($taxe): self
    {
        $this->taxe = $taxe;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

}
