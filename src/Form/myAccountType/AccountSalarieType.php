<?php

namespace App\Form\MyAccountType;

use App\Entity\Salarie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AccountSalarieType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
           // image de profil de l'user
           ->add('imgUserAvatar', FileType::class, [
            'label' => "Ajouter votre photo de profil",
            'mapped' => false,
            'required' => false
        ])
            ->add('email'    , EmailType::class)
            ->add('firstName', TextType::class)
            ->add('lastName' , TextType::class)
            ->add('telephone', TelType::class, [
                'required' => false
            ])
            ->add('civilite', ChoiceType::class, [
                'multiple'=> false,
                'expanded'=> true,
                'choices' => [
                    'Madame'  =>'Madame',
                    'Monsieur'=>'Monsieur'
                ]
            ])
            ->add('birthdate', BirthdayType::class, [
                'label'       => 'Date de naissance',
                'format'      => 'dd-MM-yyyy', 
                'required'    => false,
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'
                ]
            ])
            ->add('currentJob', TextType::class, [
                'required' => false
            ])
            ->add('companyName', TextType::class, [
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Salarie::class,
        ]);
    }
}
