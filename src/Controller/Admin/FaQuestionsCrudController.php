<?php

namespace App\Controller\Admin;

use App\Entity\FaQuestions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FaQuestionsCrudController extends AbstractCrudController {
    public static function getEntityFqcn():string {
        return FaQuestions::class;
    }

    public function configureFields(string $pageName):iterable {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('titre'),
            TextEditorField::new('description'),
            AssociationField::new('pole'),
            AssociationField::new('author')
        ];
    }
}