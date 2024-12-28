<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Entity\Delivery;
use App\Entity\Order;
use App\Entity\OrderLine;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateField::new('OrderDate'),
            TextField::new('destAddress'),
            TextField::new('destPostCode'),
            TextField::new('destCity'),
            ChoiceField::new('status')->setChoices(['EN LIVRAISON'=>'EN LIVRAISON','VALIDE'=>'VALIDE', 'LIVRE'=>'LIVRE']),
            AssociationField::new('client')->setFormTypeOptions(['disabled'=>true,'choice_label'=> function (Client $c): string {
                return $c->getAccount()->getFirstname() . ' ' . $c->getAccount()->getLastname();
            }, 'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('c')
                    ->join('c.account', 'a')
                    ->orderBy('a.lastname', 'ASC')
                    ->addOrderBy('a.firstname', 'ASC');
            }

            ])->formatValue(function ($value): string {
                return $value->getAccount()->getFirstname() . ' ' . $value->getAccount()->getLastname();
            }),
            AssociationField::new('orderLines')->setFormTypeOptions(['disabled'=>true,'choice_label'=> function (OrderLine $orderLine): string {
                return $orderLine->getQuantity().' '.$orderLine->getArticle()->getName();
            },'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('ol')
                    ->join('ol.article', 'a')
                    ->orderBy('a.name', 'ASC');
            }]),
            AssociationField::new('delivery')->setFormTypeOptions(['choice_label' => function (Delivery $d): string {
                return $d->getDeliveryDate()->format("d/m/Y");
            }, 'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('d')
                    ->orderBy('d.deliveryDate', 'ASC');
            }])->formatValue(function ($value) {
                if ($value) {
                    return $value->getDeliveryDate()->format("d/m/Y");
                } else {
                    return null;
                }
            })->setSortProperty('deliveryDate'),
        ];
    }
}
