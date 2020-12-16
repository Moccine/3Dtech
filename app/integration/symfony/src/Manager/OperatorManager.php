<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Agency;
use App\Entity\Operator;
use App\Service\Security\PasswordService;
use Doctrine\ORM\EntityManagerInterface;

class OperatorManager
{
    private EntityManagerInterface $entityManager;

    private PasswordService $passwordService;

    private EntityManagerInterface $em;

    public function __construct(
        EntityManagerInterface $entityManager,
        PasswordService $passwordService
    ) {
        $this->entityManager = $entityManager;
        $this->passwordService = $passwordService;
    }

    private function encodePassword(Operator $operator, string $password): void
    {
        $operator->setPassword($this->passwordService->encode($operator, trim($password)));
    }

    public function updateAgency(Operator $operator, Agency $agency): void
    {
        $operator->setAgency($agency);

        $this->entityManager->flush();
    }

    public function changePassword(Operator $operator, $password): void
    {
        $this->encodePassword($operator, $password);

        $this->entityManager->persist($operator);
        $this->entityManager->flush();
    }
}
