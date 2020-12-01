<?php

declare(strict_types=1);

namespace App\Manager;

use App\Controller\Account\OrderController;
use App\Entity\Client;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;

class OrderManager
{
    private EntityManagerInterface $entityManager;
    private Security $security;
    private PaginatorInterface $paginator;
    private SessionInterface $session;

    public function __construct(EntityManagerInterface $entityManager, Security $security, PaginatorInterface $paginator, SessionInterface $session)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->paginator = $paginator;
        $this->session = $session;
    }

    public function create(Order $order): void
    {
        if ($this->security->getUser()) {
            $order->setClient($this->security->getUser()->getClient());
        }

        $order
            ->setStatus(Order::STATUS_PENDING)
            ->setReference($this->generateReference());

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    public function update($order): void
    {
        $order->setPurchases($order->getPurchases());
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    public function remove(): void
    {
        $reference = $this->session->get('reference');

        if ($reference) {
            $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);

            if ($order) {
                foreach ($order->getPurchases() as $purchase) {
                    $this->entityManager->remove($purchase);
                }
                $this->entityManager->flush();
            }
        }
    }

    public function updateOption($order): void
    {
        $order->setOptions($order->getOptions());
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    public function confirm(Order $order): void
    {
        if ($this->security->getUser()) {
            if (Order::STATUS_PENDING == $order->getStatus()) {
                $order->setStatus(Order::STATUS_PAID);

                $this->entityManager->persist($order);
                $this->entityManager->flush();
            }
        }
    }

    public function changeType(Order $order)
    {
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    public function getClientList(Client $client, Request $request)
    {
        $query = $this->entityManager->getRepository(Order::class)->orderList($client->getId());

        return $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            OrderController::PAGER_DEFAULT_LIMIT
        );
    }

    private function generateReference(): string
    {
        $referenceUnique = $this->randomize(Order::REFERENCE_LENGTH);
        $reference = $this->entityManager->getRepository(Order::class)->findOneByReference($referenceUnique);

        if (false == $reference) {
            return $referenceUnique;
        } else {
            return $this->generateReference();
        }
    }

    private function randomize($length): string
    {
        $string = '';
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        for ($i = 0; $i < $length; ++$i) {
            $string .= $characters[rand(0, \strlen($characters) - 1)];
        }

        return $string;
    }
}
