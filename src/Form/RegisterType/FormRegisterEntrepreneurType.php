<?php

namespace App\Form\RegisterType;

use App\Entity\Entrepreneur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class FormRegisterEntrepreneurType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('passwordConfirm', PasswordType::class)
            ->add('civilite', ChoiceType::class,[
                'multiple'=> false,
                'expanded'=> true,
                'choices' => [
                    'Madame'  =>'Madame',
                    'Monsieur'=>'Monsieur'
                ]
            ])
            ->add('firstName', TextType::class)
            ->add('lastName' , TextType::class)
            ->add('birthdate', BirthdayType::class, [
                'label'       => 'Date de naissance',
                'format'      => 'dd-MM-yyyy', 
                'required'    => false,
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Entrepreneur::class,
        ]);
    }
}
