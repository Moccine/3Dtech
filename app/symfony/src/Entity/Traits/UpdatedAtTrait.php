<?php


namespace App\Entity\Traits;


use DateTime;

/**
 * Trait UpdatedAtTrait
 * @package App\Entity\Traits
 */
trait UpdatedAtTrait
{

    /**
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected DateTime $updatedAt;

    /**
     * @param $updatedAt
     * @return $this
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function onUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

}