<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Attribute;
use App\Entity\MachineAttribute;
use Doctrine\ORM\EntityManagerInterface;

class MachineAttributeManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(Attribute $attribute, array $data): MachineAttribute
    {
        $machineAttribute = new MachineAttribute();
        $machineAttribute
            ->setAttribute($attribute)
            ->setValue($data);
        $this->entityManager->persist($machineAttribute);

        return $machineAttribute;
    }
}
