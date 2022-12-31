<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\ProductType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ProductYukaApi');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Produits', 'fas fa-cart-shopping', Product::class);
        yield MenuItem::linkToCrud('Types de produit', 'fas fa-tag', ProductType::class);
    }
}
