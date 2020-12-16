<?php

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Repository\MachineAttributeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MachineAttributeRepository::class)
 */
class MachineAttribute
{
    use IdentifiableTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Attribute::class, inversedBy="machineAttributes")
     */
    private Attribute $attribute;

    /**
     * @ORM\ManyToOne(targetEntity=Machine::class, inversedBy="machineAttributes")
     */
    private ?Machine $machine;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private array $value = [];

    public function getAttribute(): Attribute
    {
        return $this->attribute;
    }

    public function setAttribute(?Attribute $attribute): self
    {
        $this->attribute = $attribute;

        return $this;
    }

    public function getMachine(): ?Machine
    {
        return $this->machine;
    }

    public function setMachine(?Machine $machine): self
    {
        $this->machine = $machine;

        return $this;
    }

    public function getValue(): ?array
    {
        return $this->value;
    }

    public function setValue(array $value = []): self
    {
        $this->value = $value;

        return $this;
    }
}
