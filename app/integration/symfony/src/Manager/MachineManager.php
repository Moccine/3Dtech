<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Machine;
use Doctrine\ORM\EntityManagerInterface;

class MachineManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(string $code): Machine
    {
        $machine = new Machine();
        $machine->setCode($code);
        $this->entityManager->persist($machine);

        return $machine;
    }
}
