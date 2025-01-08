<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop')]
    public function index(ArticleRepository $articleRepository, #[MapQueryParameter] string $search = ''): Response
    {
        $recherche = $search;
        $articles = $articleRepository->search($search);

        return $this->render('shop/index.html.twig', [
            'articles' => $articles,
            'search' => $search,
        ]);
    }

    #[Route('/shop/cart', name: 'app_shop_cart')]
    public function show(): Response
    {
        return $this->render('shop/show.html.twig');
    }
}
