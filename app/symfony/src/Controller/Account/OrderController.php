<?php

declare(strict_types=1);

namespace App\Controller\Account;

use App\Manager\OrderManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    const PAGER_DEFAULT_LIMIT = 10;

    /**
     * @Route("account/order", name="order_list", methods={"GET", "POST"})
     * @param OrderManager $orderManager
     * @param Request $request
     * @return Response
     */
    public function orderListAction(OrderManager $orderManager, Request $request): Response
    {
        $list = $orderManager->getClientList($this->getUser()->getClient(), $request);

        return $this->render('account/order/list.html.twig', [
            'list' => $list,
        ]);
    }
}
