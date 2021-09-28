<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticlesCrudController extends AbstractCrudController {
    public static function getEntityFqcn():string {
        return Articles::class;
    }

    public function configureFields(string $pageName):iterable {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('titreArticle'),
            TextField::new('accroche'),
            TextField::new('intro'),
            TextEditorField::new('contenu'),
            AssociationField::new('pole'),
            AssociationField::new('author'),
        ];
    }
}