<?php

namespace App\Controller\Admin;

use App\Entity\Abonnement;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AbonnementCrudController extends AbstractCrudController {
    public static function getEntityFqcn():string {
        return Abonnement::class;
    }
    
    public function configureFields(string $pageName): iterable {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title'),
            TextEditorField::new('description'),
            MoneyField::new('price')->setCurrency('EUR'),
            DateTimeField::new('createdAt'),
            DateTimeField::new('status'),
        ];
    }
}