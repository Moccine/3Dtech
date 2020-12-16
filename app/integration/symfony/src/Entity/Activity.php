<?php

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Repository\ActivityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActivityRepository::class)
 */
class Activity
{
    use IdentifiableTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
	private string $title;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
