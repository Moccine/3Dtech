<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Family;
use Doctrine\ORM\EntityManagerInterface;

class FamilyManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(string $code, ?string $label): Family
    {
        $family = new Family();
        $family->setLabel($label);
        $family->setCode($code);
        $this->entityManager->persist($family);

        return $family;
    }
}
