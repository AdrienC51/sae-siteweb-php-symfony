<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop')]
    public function index(): Response
    {
        return $this->render('shop/show.html.twig');
    }

    #[Route('/shop/cart', name: 'app_shop')]
    public function show(): Response
    {
        return $this->render('shop/show.html.twig');
    }
}
