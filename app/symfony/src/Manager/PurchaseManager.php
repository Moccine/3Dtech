<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Machine;
use App\Entity\Order;
use App\Entity\Purchase;
use Doctrine\ORM\EntityManagerInterface;

class PurchaseManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(Purchase $purchase, Machine $machine, Order $order): void
    {
        $purchase
            ->setMachine($machine)
            ->setAmount(Purchase::DEFAULT_AMOUNT)
            ->setOrder($order);

        $this->entityManager->persist($purchase);
        $this->entityManager->flush();
    }
}
