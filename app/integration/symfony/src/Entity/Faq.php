<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FaqRepository::class)
 */
class Faq
{
    use IdentifiableTrait;

    /**
     * @ORM\Column()
     */
    private ?string $question = null;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $answer = null;

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }
}
