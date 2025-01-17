<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Unit;
use App\Form\UnitType;
use App\Repository\ArticleRepository;
use App\Repository\StockEvolutionRepository;
use App\Repository\UnitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]

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
    #[Route('/stock/{id}', name: 'app_stock_detail', requirements: ['id' => '\d+'])]
    public function detail(Article $article, StockEvolutionRepository $SERepository, EntityManagerInterface $entityManager, Request $request, UnitRepository $unitRepository): Response
    {
        $stockEvolutions = $SERepository->findByArticleIdOrderedByDate($article->getId());
        $unit = new Unit();
        $form = $this->createForm(UnitType::class, $unit);
        $form->handleRequest($request);
        $delete = $this->createFormBuilder()
            ->add('delete', SubmitType::class)
            ->getForm();
        $delete->handleRequest($request);
        if ($delete->isSubmitted() && $delete->isValid()) {
            $units = $unitRepository->findExpiredByArticle($article->getId());
            foreach ($units as $unit) {
                $entityManager->remove($unit);
            }
            $entityManager->flush();
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $unit->setArticle($article);
            $unit->setEntryDate(new \DateTime('now'));
            $entityManager->persist($unit);
            $entityManager->flush();
        }
        return $this->render('stock/detail.html.twig', ["article"=>$article,"se"=>$stockEvolutions,'form'=>$form, 'delete'=>$delete]);
    }
}
