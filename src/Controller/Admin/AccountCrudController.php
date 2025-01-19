<?php

namespace App\Controller\Admin;

use App\Entity\Account;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return Account::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email'),
            ArrayField::new('roles')->formatValue(function ($value) {
                if (in_array('ROLE_ADMIN', $value)) {
                    return '<span class="material-symbols-outlined">
engineering
</span>';
                } elseif (in_array('ROLE_USER', $value)) {
                    return '<span class="material-symbols-outlined">
person
</span>';
                } else {
                    return '';
                }
            }),
            TextField::new('password')->hideOnIndex()->hideOnDetail()->setFormType(PasswordType::class)->setRequired(false)->setFormTypeOptions(['mapped' => false, 'empty_data' => ''])->setHtmlAttribute('autocomplete', 'new-password'),
            TextField::new('firstname'),
            TextField::new('lastname'),
            AssociationField::new('client', 'ID CLient')->setFormTypeOptions(['disabled' => 'true', 'choice_label' => 'id'])->formatValue(function ($value) {
                if (!is_null($value)) {
                    return "client {$value->getId()}";
                } else {
                    return 'admin';
                }
            })->setSortProperty('id'),
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::updateEntity($entityManager, $entityInstance);

        $this->setAccountPassword($entityInstance);
        $entityManager->flush();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setAccountPassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
        $entityManager->flush();
    }

    public function setAccountPassword(Account $account): void
    {
        $password = $this->getContext()->getRequest()->get('Account')['password'];
        if (null !== $password) {
            $account->setPassword($this->passwordHasher->hashPassword($account, $password));
        }
    }
}
