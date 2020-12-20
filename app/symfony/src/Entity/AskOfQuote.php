<?php

namespace App\Entity;

use App\Repository\AskOfQuoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AskOfQuoteRepository::class)
 */
class AskOfQuote
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Product::class, cascade={"persist", "remove"})
     * @Assert\NotBlank()
     */
    private $product;

    /**
     * @ORM\OneToOne(targetEntity=Deadlines::class, cascade={"persist", "remove"})
     * @Assert\NotBlank()
     */
    private $deadLine;

    /**
     * @ORM\Column(type="integer")
     *
     */
    private $materialNumber = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $serverNumber = 0;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank()
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\Email ()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank ()
     */
    private $phone;

    /**
     * @ORM\Column(type="text")
     *  @Assert\NotBlank ()
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getDeadLine(): ?Deadlines
    {
        return $this->deadLine;
    }

    public function setDeadLine(?Deadlines $deadLine): self
    {
        $this->deadLine = $deadLine;

        return $this;
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
}
