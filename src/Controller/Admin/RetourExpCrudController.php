<?php

namespace App\Controller\Admin;

use App\Entity\RetourExp;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RetourExpCrudController extends AbstractCrudController {
    public static function getEntityFqcn():string {
        return RetourExp::class;
    }

    public function configureFields(string $pageName):iterable {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('titrePublication'),
            TextEditorField::new('contenu'),
            TextField::new('accroche'),
            TextField::new('intro'),
            AssociationField::new('author')
        ];
    }
}