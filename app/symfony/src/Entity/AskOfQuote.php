<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\AskOfQuoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AskOfQuoteRepository::class)
 * @ORM\HasLifecycleCallbacks()
 *
 */
class AskOfQuote
{
    use CreatedAtTrait;
    use UpdatedAtTrait;
    use IdentifiableTrait;



    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     *
     */
    private $materialNumber = 0;


    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $serverNumber = 0;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email ()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank  ()
     */
    private $phone;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank ()
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Deadlines::class)
     */
    private $deadline;

    /**
     * AskOfQuote constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }


    public function getMaterialNumber(): ?int
    {
        return $this->materialNumber;
    }

    public function setMaterialNumber(int $materialNumber): self
    {
        $this->materialNumber = $materialNumber;

        return $this;
    }

    public function getServerNumber(): ?int
    {
        return $this->serverNumber;
    }

    public function setServerNumber(int $serverNumber): self
    {
        $this->serverNumber = $serverNumber;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDeadline(): ?Deadlines
    {
        return $this->deadline;
    }

    public function setDeadline(?Deadlines $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }
}
