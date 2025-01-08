<?php

namespace App\Controller\Admin;

use App\Entity\Account;
use App\Entity\CartLine;
use App\Entity\Client;
use App\Entity\Order;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('address'),
            TextField::new('postcode'),
            TextField::new('city'),
            TelephoneField::new('phone'),
            AssociationField::new('account')->setFormTypeOptions(['disabled'=>'true','choice_label'=>'email'])->formatValue(function (Account $value) {
                return $value->getFirstName() . ' ' . $value->getLastName();
            }),
            AssociationField::new('orders')->setFormTypeOptions(['disabled'=>'true', 'choice_label' => function (Order $o): string {
                return $o->getId().'-'.$o->getOrderDate()->format("d/m/Y");
            }]),
            AssociationField::new('cartLines')->setFormTypeOptions(['disabled'=>'true', 'choice_label' => function (CartLine $cl): string {
                return $cl->getQuantity() . ' ' . $cl->getArticle()->getName();
            }]),
            ];
    }
}
