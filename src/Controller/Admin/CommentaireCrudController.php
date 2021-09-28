<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentaireCrudController extends AbstractCrudController {
    public static function getEntityFqcn():string {
        return Commentaire::class;
    }
    
    public function configureFields(string $pageName):iterable {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextEditorField::new('contenu'),
            AssociationField::new('userCommentaire'),
            AssociationField::new('retourExp'),
            AssociationField::new('article')
        ];
    } 
}