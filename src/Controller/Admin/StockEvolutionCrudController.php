<?php

namespace App\Controller\Admin;

use App\Entity\StockEvolution;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StockEvolutionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StockEvolution::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('quantity'),
            ChoiceField::new('type')->setChoices(['IN'=>'IN','OUT'=>'OUT']),
            AssociationField::new('article')->setFormTypeOptions(['disabled'=> true, 'choice_label' => 'name', 'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('a')
                    ->orderBy('a.name', 'ASC');
            }])->formatValue(function ($value) {
                return $value->getName();
            }),
            DateField::new('evolutionDate'),

        ];
    }
}
