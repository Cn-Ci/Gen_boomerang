<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ImageCrudController extends AbstractCrudController {
    public static function getEntityFqcn():string {
        return Image::class;
    }
 
    public function configureFields(string $pageName):iterable {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('titre'),
            ImageField::new('imageArt')
                ->setBasePath('uploads/articles/')
                ->setUploadDir('public/uploads/articles/')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            ImageField::new('imageRExp')
                ->setBasePath('uploads/retourExp/')
                ->setUploadDir('public/uploads/retourExp/')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            ImageField::new('userAvatar')
                ->setBasePath('uploads/userAvatar/')
                ->setUploadDir('public/uploads/userAvatar/')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            AssociationField::new('imgArticle'),
            AssociationField::new('imgRetourExp'),
            AssociationField::new('imgUserAvatar'),
        ];
    }   
}