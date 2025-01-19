<?php

namespace App\Controller\Admin;

use App\Entity\KeyWord;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class KeyWordCrudController extends AbstractCrudController
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public static function getEntityFqcn(): string
    {
        return KeyWord::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('word'),
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

    public function setUpdateArticles(KeyWord $keyWord): void
    {
        $allArticles = $this->articleRepository->findAll();

        if (isset($this->getContext()->getRequest()->get('KeyWord')['articles'])) {
            $articlesId = $this->getContext()->getRequest()->get('KeyWord')['articles'];

            foreach ($allArticles as $article) {
                if ($article->getKeyWords()->contains($keyWord)) {
                    if (!in_array($article->getId(), $articlesId)) {
                        $article->removeKeyWord($keyWord);
                    }
                } elseif (in_array($article->getId(), $articlesId)) {
                    $article->addKeyWord($keyWord);
                }
            }
        } else {
            foreach ($allArticles as $article) {
                if ($article->getKeyWords()->contains($keyWord)) {
                    $article->removeKeyWord($keyWord);
                }
            }
        }
    }
}
