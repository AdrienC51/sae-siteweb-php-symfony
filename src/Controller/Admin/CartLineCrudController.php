<?php

namespace App\Controller\Admin;

use App\Entity\CartLine;
use App\Entity\Client;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CartLineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CartLine::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('quantity'),
            AssociationField::new('client', 'Cart')->setFormTypeOptions(['choice_label'=> function (Client $client): string {
                return $client->getId().'-'.$client->getAccount()->getFirstname().' '.$client->getAccount()->getLastName();
            }])
                ->formatValue(function ($client) {
                    return $client->getId().'-'.$client->getAccount()->getFirstname().' '.$client->getAccount()->getLastName();
                }),
            AssociationField::new('article')->setFormTypeOptions(['choice_label'=>'name', 'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('a')
                    ->orderBy('a.name', 'ASC');
            }])
                ->formatValue(function ($article) {
                    return $article->getName();
                }),
        ];
    }

}
