<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\KeyWord;
use App\Entity\StockEvolution;
use App\Entity\Unit;
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




    }
}
