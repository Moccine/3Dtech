<?php


namespace App\Entity\Traits;


use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait CreatedAtTrait
 * @package App\Entity\Traits
 */
trait CreatedAtTrait
{
    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @param $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPersist()
    {
        $this->createdAt = new DateTime();
    }
}