<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\User;
use App\Service\Security\PasswordService;
use Doctrine\ORM\EntityManagerInterface;

class ClientManager
{
    private EntityManagerInterface $entityManager;
    private PasswordService $passwordService;

    public function __construct(EntityManagerInterface $entityManager, PasswordService $passwordService)
    {
        $this->entityManager = $entityManager;
        $this->passwordService = $passwordService;
    }

    public function edit(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
