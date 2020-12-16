<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Form\PaymentType;
use App\Manager\OrderManager;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order/{id}/cart/", name="cart", methods={"GET", "POST"})
     *
     * @throws Exception
     */
    public function cart(Order $order, OrderManager $orderManager, Request $request)
    {
        $form = $this->createForm(OrderType::class, $order, ['step' => 1]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderManager->update($order);
        }

        return $this->render('front/order/cart.html.twig', [
            'form' => $form->createView(),
            'order' => $order,
        ]);
    }

    /**
     * @Route("/cart/empty/", name="cart_empty", methods={"GET", "POST"})
     *
     * @throws Exception
     */
    public function cartEmpty(OrderManager $orderManager)
    {
        try {
            $orderManager->remove();
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $this->redirectToRoute('account_home');
    }

    /**
     * @Route("/order/{id}/location/", name="location", methods={"GET", "POST"})
     *
     * @throws Exception
     */
    public function location(Order $order, OrderManager $orderManager, Request $request)
    {
        $form = $this->createForm(OrderType::class, $order, ['step' => 2]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderManager->updateOption($order);
        }

        return $this->render('front/order/location.html.twig', [
            'form' => $form->createView(),
            'order' => $order,
        ]);
    }

    /**
     * @Route("/order/{id}/payment/", name="payment", methods={"GET", "POST"})
     *
     * @throws Exception
     */
    public function payment(Order $order, OrderManager $orderManager, Request $request)
    {
        if (Order::TYPE_QUOTATION == $order->getType()) {
            $order->setType(Order::TYPE_BILL);
        }

        $form = $this->createForm(PaymentType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderManager->changeType($order);

            return $this->redirectToRoute('confirmation', ['id' => $order->getId()]);
        }

        return $this->render('front/order/payment.html.twig', [
            'form' => $form->createView(),
            'order' => $order,
        ]);
    }

    /**
     * @Route("/order/{id}/confirmation/", name="confirmation", methods={"GET", "POST"})
     *
     * @throws Exception
     */
    public function confirmation(Order $order, OrderManager $orderManager)
    {
        $orderManager->confirm($order);

        return $this->render('front/order/confirmation.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("order/{id}/download", name="download_PDF")
     */
    public function downloadAction(Order $order, Pdf $pdf, OrderManager $orderManager)
    {
        $orderPdf = $this->render('front/order/order.pdf.twig', [
            'order' => $order,
        ]);

        $orderManager->changeType($order);

        return new PdfResponse(
            $pdf->getOutputFromHtml($orderPdf),
            sprintf('NetRent-%s.pdf', $order->getReference())
        );
    }
}
