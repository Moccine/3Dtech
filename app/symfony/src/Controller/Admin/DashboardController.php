<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Address;
use App\Entity\Category;
use App\Entity\Client;
use App\Entity\Deadlines;
use App\Entity\Invoice;
use App\Entity\Product;
use App\Entity\Quotation;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        // return parent::index();
        return $this->redirect($routeBuilder->setController(ClientCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('3DTECH')
            ->setTitle('Tableau de bord')
            ->setFaviconPath('favicon.svg')
            ->setTranslationDomain('my-custom-domain')
            ->setTextDirection('ltr')
            ;
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::section('Menu Important');
        yield MenuItem::linkToCrud('Clients', 'fas fa-user', Client::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Devis', 'fas fa-calculator', Quotation::class);
        yield MenuItem::linkToCrud('Produit', 'fas fa-link', Product::class);
        yield MenuItem::linkToCrud('Category', 'fas fa-list-alt', Category::class);
        yield MenuItem::linkToCrud('Deadlines', 'fas fa-calendar-week', Deadlines::class);
        yield MenuItem::linkToCrud('Address', 'fas fa-map-marker-alt', Address::class);
        yield MenuItem::linkToCrud('Client', 'fas fa-users', Client::class);
        yield MenuItem::linkToCrud('Invoice', 'fas fa-file-invoice', Invoice::class);
    }
}
