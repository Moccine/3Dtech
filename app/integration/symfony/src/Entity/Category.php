<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\CodifiableTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository", repositoryClass=CategoryRepository::class)
 * @UniqueEntity(fields={"code"})
 */
class Category
{
    use IdentifiableTrait;
    use CodifiableTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Family::class, inversedBy="category")
     */
    private Family $family;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $label;

    public function getFamily(): Family
    {
        return $this->family;
    }

    public function setFamily(Family $family): void
    {
        $this->family = $family;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }
}
