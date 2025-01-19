<?php

namespace App\Controller\Admin;

use App\Entity\Restocking;
use App\Entity\RestockingLine;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class RestockingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Restocking::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateField::new('restockDate'),
            ChoiceField::new('status')->setChoices(['PENDING' => 'Pending', 'RECEIVED' => 'Received']),
            AssociationField::new('restockingLines')->setFormTypeOptions(['disabled' => true, 'choice_label' => function (RestockingLine $restockingLine): string {
                return $restockingLine->getQuantity().' '.$restockingLine->getArticle()->getName();
            }, 'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('rl')
                    ->join('rl.article', 'a')
                    ->orderBy('a.name', 'ASC');
            }]),
        ];
    }
}
