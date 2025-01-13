<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAllOrderedByNameWithArticleCount();
        return $this->render('category/index.html.twig', ['categories' => $categories]);
    }
    #[Route('/category/{id}', name: 'app_category_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Category $category, ArticleRepository $articleRepository, #[MapQueryParameter] string $search = '', #[MapQueryParameter] string $prix_min = '', #[MapQueryParameter] string $prix_max = '' ): Response
    {
        $recherche = $search;
        $articles = $articleRepository->searchWithCategory($category->getId(), $search, $prix_min, $prix_max);

        return $this->render('shop/index.html.twig', [
            'articles' => $articles,
            'search' => $search,
            'prix_min' => $prix_min,
            'prix_max' => $prix_max,
            'categoryId' => $category->getId(),
        ]);
    }
}
