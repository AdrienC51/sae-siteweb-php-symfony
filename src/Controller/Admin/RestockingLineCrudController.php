<?php

namespace App\Controller\Admin;

use App\Entity\Restocking;
use App\Entity\RestockingLine;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class RestockingLineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RestockingLine::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('quantity'),
            AssociationField::new('restocking')->setFormTypeOptions(['choice_label' => function (Restocking $restocking): string {
                return $restocking->getId().'-'.$restocking->getRestockDate()->format('d/m/Y');
            }])
                ->formatValue(function ($restocking) {
                    return $restocking->getId().'-'.$restocking->getRestockDate()->format('d/m/Y');
                }),
            AssociationField::new('article')->setFormTypeOptions(['choice_label' => 'name', 'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('a')
                    ->orderBy('a.name', 'ASC');
            }])
                ->formatValue(function ($article) {
                    return $article->getName();
                }),
        ];
    }
}
