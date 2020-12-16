<?php

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    use IdentifiableTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $command;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $executedAt;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    private ?string $logFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $terminatedAt;

    public function getCommand(): ?string
    {
        return $this->command;
    }

    public function setCommand(string $command): self
    {
        $this->command = $command;

        return $this;
    }

    public function getExecutedAt(): \DateTimeInterface
    {
        return $this->executedAt;
    }

    public function setExecutedAt(\DateTimeInterface $executedAt): self
    {
        $this->executedAt = $executedAt;

        return $this;
    }

    public function getLogFile(): ?string
    {
        return $this->logFile;
    }

    public function setLogFile(?string $logFile): self
    {
        $this->logFile = $logFile;

        return $this;
    }

    public function getTerminatedAt(): ?\DateTimeInterface
    {
        return $this->terminatedAt;
    }

    public function setTerminatedAt(?\DateTimeInterface $terminatedAt): self
    {
        $this->terminatedAt = $terminatedAt;

        return $this;
    }
}
