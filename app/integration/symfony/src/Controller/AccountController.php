<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\OrderManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account_home", methods={"GET", "POST"})
     */
    public function registration(OrderManager $orderManager): Response
    {
        $order = $orderManager->getOrderByReference();

        return $this->render('account/default/index.html.twig', [
            'order' => $order,
        ]);
    }
}
