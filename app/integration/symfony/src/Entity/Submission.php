<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Repository\SubmissionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SubmissionRepository::class)
 */
class Submission
{
    use IdentifiableTrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank ()
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank ()
     */
    private string $lastName;

    /**
     * @ORM\Column(length=180, unique=true)
     * @Assert\NotBlank ()
     * @Assert\Email()
     */
    private string $email;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private string $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $submittedAt;

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getSubmittedAt(): ?\DateTime
    {
        return $this->submittedAt;
    }

    public function setSubmittedAt(\DateTime $submittedAt): self
    {
        $this->submittedAt = $submittedAt;

        return $this;
    }
}
