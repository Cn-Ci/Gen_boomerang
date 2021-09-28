<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController {
    public static function getEntityFqcn():string {
        return User::class;
    }

    public function configureFields(string $pageName):iterable {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('type'),
            TextField::new('civilite'),
            TextField::new('firstName'),
            TextField::new('LastName'),
            TextField::new('email'),
            BooleanField::new('isVerified'),
            TelephoneField::new('telephone'),
            DateTimeField::new('birthdate'),
            TextEditorField::new('description'),
            AssociationField::new('abonnement'),
        ];
    }

    public function configureActions(Actions $actions): Actions {
        return $actions
            ->disable(Action::NEW)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }
}