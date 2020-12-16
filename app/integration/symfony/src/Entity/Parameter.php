<?php

namespace App\Entity;

use App\Entity\Traits\CodifiableTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Repository\ParameterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParameterRepository::class)
 */
class Parameter
{
    use IdentifiableTrait;
    use CodifiableTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
