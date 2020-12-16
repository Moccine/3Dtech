<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\CodifiableTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Repository\MachineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MachineRepository::class)
 */
class Machine
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
     * @ORM\OneToMany(targetEntity=MachineAttribute::class, mappedBy="machine")
     */
    private Collection $machineAttributes;

    /**
     * @ORM\ManyToOne(targetEntity=Agency::class, inversedBy="machines")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Agency $agency;

    /**
     * @ORM\ManyToMany(targetEntity=Activity::class)
     */
    private Collection $activities;

    public function __construct()
    {
        $this->machineAttributes = new ArrayCollection();
        $this->activities = new ArrayCollection();
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
     * @return Collection|MachineAttribute[]
     */
    public function getMachineAttributes(): Collection
    {
        return $this->machineAttributes;
    }

    public function addMachineAttribute(MachineAttribute $machineAttribute): self
    {
        if (!$this->machineAttributes->contains($machineAttribute)) {
            $this->machineAttributes[] = $machineAttribute;
            $machineAttribute->setMachine($this);
        }

        return $this;
    }

    public function removeMachineAttribute(MachineAttribute $machineAttribute): self
    {
        if ($this->machineAttributes->contains($machineAttribute)) {
            $this->machineAttributes->removeElement($machineAttribute);
            // set the owning side to null (unless already changed)
            if ($machineAttribute->getMachine() === $this) {
                $machineAttribute->setMachine(null);
            }
        }

        return $this;
    }

    public function getAgency(): ?Agency
    {
        return $this->agency ?? null;
    }

    public function setAgency(?Agency $agency): self
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        $this->activities->removeElement($activity);

        return $this;
    }
}
