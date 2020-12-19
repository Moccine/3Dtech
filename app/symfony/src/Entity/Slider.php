<?php

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Repository\SliderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass=SliderRepository::class)
 * @Vich\Uploadable
 */
class Slider
{
    use IdentifiableTrait;

    /**
     * @Vich\UploadableField(mapping="slide_images", fileNameProperty="image")
     * @var File
     */
    private  $file = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private  $image;

    /**
     * @ORM\ManyToOne(targetEntity=Slideshow::class, inversedBy="slides", cascade={"persist"})
     */
    private Slideshow $slideshow;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $title;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private \DateTime $updatedAt;

    public function getSlideshow(): ?Slideshow
    {
        return $this->slideshow;
    }

    public function setSlideshow(Slideshow $slideshow): self
    {
        $this->slideshow = $slideshow;

        return $this;
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

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file)
    {
        $this->file = $file;

        if (null !== $file) {
            $this->updatedAt = new \DateTime();
        }
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

}
