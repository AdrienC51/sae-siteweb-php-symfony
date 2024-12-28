<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\OrderLine;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderLineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderLine::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('quantity'),
            AssociationField::new('relatedOrder')->setFormTypeOptions(['choice_label'=> function (Order $order): string {
                return $order->getId().'-'.$order->getOrderDate()->format('d/m/Y').'-'.$order->getClient()->getAccount()->getFirstName().' '.$order->getClient()->getAccount()->getLastName();
            }])
            ->formatValue(function ($order) {
                return $order->getId().'-'.$order->getOrderDate()->format('d/m/Y').'-'.$order->getClient()->getAccount()->getFirstName().' '.$order->getClient()->getAccount()->getLastName();
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
