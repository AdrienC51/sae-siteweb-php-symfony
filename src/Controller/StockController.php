<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class StockController extends AbstractController
{
    #[Route('/stock', name: 'app_stock')]
    public function index(ArticleRepository $articleRepository, #[MapQueryParameter] string $search = '', #[MapQueryParameter] string $prix_min = '', #[MapQueryParameter] string $prix_max = ''): Response
    {
        $recherche = $search;
        $articles = $articleRepository->search($search, $prix_min, $prix_max);

        return $this->render('stock/index.html.twig', [
            'articles' => $articles,
            'search' => $search,
            'prix_min' => $prix_min,
            'prix_max' => $prix_max,
        ]);
    }
}
