<?php

namespace App\Controller\Admin;

use App\Entity\Account;
use App\Entity\Client;
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
        ];
    }
}
