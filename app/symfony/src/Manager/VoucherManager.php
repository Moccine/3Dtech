<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Voucher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class VoucherManager
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function create(Voucher $voucher): void
    {
        $this->entityManager->persist($voucher);
        $this->entityManager->flush();
    }

    public function update(Voucher $voucher): void
    {
        $this->entityManager->flush();
    }
}
