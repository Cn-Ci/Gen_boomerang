<?php

namespace App\Form;

use App\Form\ImagesType;
use App\Entity\RetourExp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RetourExpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('titrePublication', TextType::class)
            ->add('accroche', TextType::class)
            ->add('intro', TextareaType::class)
            ->add('contenu', TextareaType::class)
            // image de profil de l'article
            ->add('imgRetourExp', FileType::class, [
                'label' => "Ajouter l'image qui représente votre retour d'experience",
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
            'data_class' => RetourExp::class,
        ]);
    }
}
