<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\CodifiableTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Repository\FamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FamilyRepository::class)
 */
class Family
{
    use IdentifiableTrait;
    use CodifiableTrait;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $label;

    /**
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="family", cascade={"persist"})
     */
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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

    public function getCategories(): ArrayCollection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setFamily($this);
        }

        return $this;
    }

    public function setCategories(ArrayCollection $categories): self
    {
        $this->categories = $categories;

        return $this;
    }
}
