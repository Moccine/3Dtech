<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Agency;
use App\Entity\Article;
use App\Entity\Faq;
use App\Entity\Letter;
use App\Entity\Page;
use App\Entity\Parameter;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/_easyadmin", name="easyadmin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Symfony');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Users'),
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
            MenuItem::subMenu('System', 'fa fa-gear')->setSubItems([
                MenuItem::linkToCrud('Admin', 'fa fa-user-o', Admin::class),
                MenuItem::linkToCrud('Parameter', 'fa fa-bars', Parameter::class),
            ]),
            MenuItem::subMenu('Application', 'fa fa-th-large')->setSubItems([
                MenuItem::linkToCrud('Agency', 'fa fa-handshake-o', Agency::class),
            ]),
            MenuItem::subMenu('CMS', 'fa fa-columns')->setSubItems([
                MenuItem::linkToCrud('Email', 'fa fa-envelope', Letter::class),
                MenuItem::linkToCrud('FAQ', 'fa fa-bars', Faq::class),
                MenuItem::linkToCrud('Article', 'fa fa-id-card-o', Article::class),
                MenuItem::linkToCrud('Page', 'fa fa-bars', Page::class),
            ]),
        ];
    }
}
