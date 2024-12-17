<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\OrderLine;
use App\Entity\Restocking;
use App\Entity\RestockingLine;
use App\Entity\Unit;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AvatarField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CurrencyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            MoneyField::new('price')->setCurrency('EUR'),
            TextEditorField::new('description'),
            AssociationField::new('categories')->setFormTypeOptions(['choice_label' => 'name', 'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
            }]),
            AssociationField::new('keyWords')->setFormTypeOptions(['choice_label' => 'word', 'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('k')
                    ->orderBy('k.word', 'ASC');
            }]),
            AssociationField::new('articlesDetail','Stock')->setFormTypeOptions(['disabled'=>'true','choice_label' => function (Unit $u): string {
                return $u->getExpirationDate()->format("d/m/Y");
            }, 'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('u')
                    ->orderBy('u.expirationDate', 'ASC');
            }]),
            AssociationField::new('restockingLines', 'restocking')->setFormTypeOptions(['disabled'=>'true', 'choice_label' => function (RestockingLine $rl): string {
                return $rl->getRestocking()->getRestockDate()->format("d/m/Y") . ' (qts :' . $rl->getQuantity() . ')';
            }, 'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('rl')
                    ->join('rl.restocking', 'r')
                    ->orderBy('r.restockDate', 'ASC');
            }]),
            AssociationField::new('orderLines', 'Orders')->setFormTypeOptions(['disabled'=>'true', 'choice_label' => function (OrderLine $ol): string {
                return $ol->getRelatedOrder()->getOrderDate()->format("d/m/Y") . ' (qts :' . $ol->getQuantity() . ')';
            }, 'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('ol')
                    ->join('ol.relatedOrder', 'r')
                    ->orderBy('r.orderDate', 'ASC');
            }]),


        ];
    }

}
