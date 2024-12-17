<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    #[Route('/article/{id}', name: 'app_article_show',requirements: ['id' => '\d+'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', ['article'=>$article]);
    }
    #[Route('/article/create', name: 'app_article_create')]
    public function create(): Response
    {
        return $this->render('article/create.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
    #[Route('/article/{id}/update', name: 'app_article_update')]
    public function update(): Response
    {
        return $this->render('article/update.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
    #[Route('/article/{id}/delete', name: 'app_article_delete')]
    public function delete(): Response
    {
        return $this->render('article/delete.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
}
