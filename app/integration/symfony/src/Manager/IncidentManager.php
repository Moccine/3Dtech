<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Incident;
use Doctrine\ORM\EntityManagerInterface;

class IncidentManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(Incident $incident): Incident
    {
        $incident->setStatus(Incident::STATUS_IN_PROGRESS);
        $this->entityManager->persist($incident);
        $this->entityManager->flush();

        return $incident;
    }
}
