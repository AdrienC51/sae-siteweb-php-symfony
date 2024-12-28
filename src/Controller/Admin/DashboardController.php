<?php

namespace App\Controller\Admin;

use App\Entity\Account;
use App\Entity\Article;
use App\Entity\CartLine;
use App\Entity\Category;
use App\Entity\Client;
use App\Entity\Delivery;
use App\Entity\KeyWord;
use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\Restocking;
use App\Entity\StockEvolution;
use App\Entity\Unit;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Back Office');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Exit', 'fa fa-sign-out', 'app_home', []);
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('CRUD Category', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('CRUD Unit', 'fas fa-list', Unit::class);
        yield MenuItem::linkToCrud('CRUD Article', 'fas fa-list', Article::class);
        yield MenuItem::linkToCrud('CRUD Key Word', 'fas fa-list', KeyWord::class);
        yield MenuItem::linkToCrud('CRUD Stock Evolution', 'fas fa-list', StockEvolution::class);
        yield MenuItem::linkToCrud('CRUD Account', 'fas fa-list', Account::class);
        yield MenuItem::linkToCrud('CRUD Client', 'fas fa-list', Client::class);
        yield MenuItem::linkToCrud('CRUD Order', 'fas fa-list', Order::class);
        yield MenuItem::linkToCrud('CRUD Delivery', 'fas fa-list', Delivery::class);
        yield MenuItem::linkToCrud('CRUD Order Lines', 'fas fa-list', OrderLine::class);
        yield MenuItem::linkToCrud('CRUD Cart Lines', 'fas fa-list', CartLine::class);
        yield MenuItem::linkToCrud('CRUD Restocking', 'fas fa-list', Restocking::class);







    }

    public function configureAssets(): Assets
    {
        $assets = parent::configureAssets();
        $assets->addCssFile('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined');
        return $assets;
    }
}
