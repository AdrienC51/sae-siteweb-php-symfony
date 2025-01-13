<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }
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

    #[Route('/category/create', name: 'app_category_create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->setUpdateArticles($category, $request);
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_category');
        }

        return $this->render('category/create.html.twig', ['category' => $category, 'form' => $form]);

    }
    public function setUpdateArticles(Category $category, Request $request): void
    {
        $allArticles = $this->articleRepository->findAll();

        if (isset($request->get("category")['articles'])) {
            $articlesId = $request->get('category')['articles'];

            foreach ($allArticles as $article) {
                if ($article->getCategories()->contains($category)) {
                    if (!in_array($article->getId(), $articlesId)) {
                        $article->removeCategory($category);
                    }
                } elseif (in_array($article->getId(), $articlesId)) {
                    $article->addCategory($category);
                }
            }
        } else {
            foreach ($allArticles as $article) {
                if ($article->getCategories()->contains($category)) {
                    $article->removeCategory($category);
                }
            }

        }
    }
}
