<?php

namespace App\Form;

use App\Form\ImageType;


use App\Entity\Articles;
use App\Form\ImagesType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ArticlesType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pole', ChoiceType::class,[
                'multiple'=> false,
                'choices' => [
                    'Innovation'                          => 'Innovation',
                    'Evolution des metiers'               => 'Evolution des metiers',
                    'Evolution des savoirs'               => 'Evolution des savoirs',
                    'Com Recherche et developpement'      => 'Com Recherche et developpement',
                    'Immobilier & Silver Experience'      => 'Immobilier & Silver Experience',
                    'Universal design & inclusive design' => 'Universal design & inclusive design',
                ]
            ])
            ->add('titreArticle',TextType::class)
            ->add('accroche',TextType::class)
            ->add('intro',TextareaType::class)
            ->add('contenu',CKEditorType::class)
            // image de profil de l'article
            ->add('imgArticle', FileType::class, [
                'label' => "Ajouter l'image qui représente votre article",
                'mapped' => false,
                'required' => false
            ])

            // images de l'articles 
            ->add('images', FileType::class, [
                'label' => 'Ajouter des images',
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])

            ->add('video',UrlType::class, [
                'required' => false,
                'attr' => array('class'=>'inputBorder')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
