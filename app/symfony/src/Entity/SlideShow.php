<?php

namespace App\Entity;

use App\Entity\Traits\CodifiableTrait;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\SlideShowRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Slider;

/**
 * @ORM\Entity(repositoryClass=SlideShowRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class SlideShow
{
    public const SLIDESHOW_HOMEPAGE = 'homepage';

    use CreatedAtTrait;
    use UpdatedAtTrait;
    use IdentifiableTrait;
    /**
     * @ORM\OneToMany(targetEntity=Slider::class, mappedBy="slideshow", cascade={"persist"})
     */
    private $slides;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;
    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $description;

    public function __toString()
    {
        return $this->title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlides()
    {
        return $this->slides;
    }

    public function setSlides($slides): self
    {
        $this->slides = $slides;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return SlideShow
     */
    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

}
