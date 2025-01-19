<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            AssociationField::new('articles')->setFormTypeOptions(['choice_label' => 'name', 'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('a')
                    ->orderBy('a.name', 'ASC');
            }]),
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setUpdateArticles($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
        $entityManager->flush();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setUpdateArticles($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
        $entityManager->flush();
    }

    public function setUpdateArticles(Category $category): void
    {
        $allArticles = $this->articleRepository->findAll();

        if (isset($this->getContext()->getRequest()->get('Category')['articles'])) {
            $articlesId = $this->getContext()->getRequest()->get('Category')['articles'];

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
