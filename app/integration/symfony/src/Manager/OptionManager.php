<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Option;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

class OptionManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(Option $option, Order $order): void
    {
        $option->setOrder($order);
        $option->setType(Option::TYPE_GUARANTEE);

        $this->entityManager->persist($option);
        $this->entityManager->flush();
    }
}
