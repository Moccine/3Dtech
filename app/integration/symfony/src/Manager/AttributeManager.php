<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Attribute;
use Doctrine\ORM\EntityManagerInterface;

class AttributeManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(string $code, array $labels): Attribute
    {
        $attribute = new Attribute();
        $attribute->setCode($code)->setLabel($labels);
        $this->entityManager->persist($attribute);

        return $attribute;
    }
}
