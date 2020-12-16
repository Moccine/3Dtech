<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Repository\AttributeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttributeRepository::class)
 */
class Attribute
{
    use IdentifiableTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $code;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private array $label = [];

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getLabel(): ?array
    {
        return $this->label;
    }

    public function setLabel(?array $label): self
    {
        $this->label = $label;

        return $this;
    }
}
