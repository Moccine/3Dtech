<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Repository\AgencyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgencyRepository::class)
 */
class Agency
{
    use IdentifiableTrait;

    /**
     * @ORM\OneToOne(targetEntity=Address::class)
     */
    private Address $address;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity=OperatorAgency::class, mappedBy="agency", cascade={"persist"})
     */
    private Collection $operatorsAgencies;

    /**
     * @ORM\ManyToOne(targetEntity=Operator::class, inversedBy="agencies")
     */
    private ?Operator $operator;

    /**
     * @ORM\OneToMany(targetEntity=Machine::class, mappedBy="agency")
     */
    private Collection $machines;

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getOperatorsAgencies(): ?ArrayCollection
    {
        return $this->operatorsAgencies;
    }

    public function setOperatorsAgencies(?ArrayCollection $operatorsAgencies): self
    {
        $this->operatorsAgencies = $operatorsAgencies;

        return $this;
    }

    public function getOperator(): ?Operator
    {
        return $this->operator;
    }

    public function setOperator(Operator $operator): self
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * @return Collection|Machine[]
     */
    public function getMachines(): Collection
    {
        return $this->machines;
    }

    public function addMachine(Machine $machine): self
    {
        if (!$this->machines->contains($machine)) {
            $this->machines[] = $machine;
            $machine->setAgency($this);
        }

        return $this;
    }

    public function removeMachine(Machine $machine): self
    {
        if ($this->machines->contains($machine)) {
            $this->machines->removeElement($machine);
            // set the owning side to null (unless already changed)
            if ($machine->getAgency() === $this) {
                $machine->setAgency(null);
            }
        }

        return $this;
    }

    /**
     * @return array|null
     */
    public function getAgencyGeoPoint()
    {
        $location = [
            'lat' => $this->address->getLatitude(),
            'lon' => $this->address->getLongitude(),
        ];

        return ($this->address->getLatitude() && $this->address->getLongitude()) ? $location : null;
    }

    public function getRoles(): array
    {
        return [Operator::ROLE_OPERATOR];
    }
}
