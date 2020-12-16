<?php

declare(strict_types=1);

namespace App\Controller;

use App\Constant\Product;
use App\Elasticsearch\MachineSearch;
use App\Entity\Machine;
use App\Entity\Option;
use App\Entity\Order;
use App\Entity\Purchase;
use App\Manager\OptionManager;
use App\Manager\OrderManager;
use App\Manager\PurchaseManager;
use App\Service\Comparator\ComparatorService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class MachineController extends AbstractController
{
    private SessionInterface $session;
    private EntityManagerInterface $entityManager;

    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/machine/index/{id}", name="machine_index", methods={"GET"})
     */
    public function index(Machine $machine)
    {
        return $this->render('front/machine/index.html.twig', [
            'machine' => $machine,
        ]);
    }

    /**
     * @Route("/machine/comparator", name="machine_comparator", methods={"GET"})
     */
    public function comparator(ComparatorService $comparatorService)
    {
        $machines = $comparatorService->getMachines();
        $attributes = $comparatorService->getAttributes();

        return $this->render('front/machine/comparator.html.twig', [
            'machines' => $machines,
            'attributes' => $attributes,
        ]);
    }

    /**
     * @Route("/machine/detail/{id}", name="machine_detail", methods={"GET"})
     */
    public function detail(Machine $machine)
    {
        return $this->render('front/machine/detail.html.twig', [
            'machine' => $machine,
        ]);
    }

    /**
     * @Route("/machine/list", name="machine_list", methods={"GET"})
     */
    public function list(MachineSearch $machineSearch)
    {
        $machines = $machineSearch->getMachineList();

        return $this->render('front/machine/list.html.twig', [
            'machines' => $machines,
        ]);
    }

    /**
     * @Route("/machine/add/comparator/{id}", name="add_comparator", methods={"GET"})
     *
     * @throws Exception
     */
    public function addComparator(Machine $machine, ComparatorService $comparatorService)
    {
        $comparatorService->addComparator($machine);
        $machines = $comparatorService->getAttributes(Product::MACHINE);
        if (\count($machines) > 3) {
            throw new Exception('Cannot have more than 3');
        }

        return $this->redirectToRoute('index_route');
    }

    /**
     * @Route("/machine/cart/{id}", name="add_to_cart", methods={"GET"})
     *
     * @throws Exception
     */
    public function addToCart(Machine $machine, OrderManager $orderManager, OptionManager $optionManager, PurchaseManager $purchaseManager)
    {
        try {
            $purchase = new Purchase();
            $order = new Order();
            $option = new Option();

            $this->entityManager->getConnection()->beginTransaction();

            $orderManager->create($order);
            $purchaseManager->create($purchase, $machine, $order);
            $optionManager->create($option, $order);

            $this->entityManager->getConnection()->commit();

            $this->session->set('reference', $order->getReference());
        } catch (Exception $e) {
            $this->entityManager->getConnection()->rollback();

            return $e->getMessage();
        }

        return $this->redirectToRoute('cart', ['id' => $order->getId()]);
    }
}
