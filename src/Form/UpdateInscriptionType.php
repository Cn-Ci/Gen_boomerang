<?php

namespace App\Form;

use App\Entity\User;
use App\Form\AdresseType;
use App\Form\ApplicationType;
use Liip\ImagineBundle\Form\Type\ImageType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;


class UpdateInscriptionType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class, $this->getConfiguration("EMAIL", "Votre adresse email..."))
            // ->add('roles')
            ->add('firstName',TextType::class, $this->getConfiguration("PRÉNOM", "Votre prénom ..."))
            ->add('lastName',TextType::class, $this->getConfiguration("NOM", "Votre nom de Famille ..."))
            ->add('telephone', TelType::class)
            ->add('civilite' , ChoiceType::class, [
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
            ->add('description',TextType::class, $this->getConfiguration("INTRODUCTION", "Présentez vous en quelques mots ..."))
      
            // image de profil de l'user
            ->add('imgUserAvatar', FileType::class, [
                'label' => "Ajouter votre photo de profil",
                'mapped' => false,
                'required' => false
            ])
            ->add('company' , EntrepriseType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
