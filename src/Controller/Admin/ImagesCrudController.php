<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ImagesCrudController extends AbstractCrudController {
    public static function getEntityFqcn():string {
        return Images::class;
    }

    public function configureFields(string $pageName):iterable {
        return [
            IdField::new('id')->onlyOnIndex(),
            ImageField::new('images')
                ->setBasePath('uploads/carousel/')
                ->setUploadDir('public/uploads/carousel/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired('false'),
            TextField::new('titreImage'),
            AssociationField::new('article'),
            AssociationField::new('retourExp'),
        ];
    }
}