<?php

namespace App\Form;

use App\Form\AdresseType;
use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EntrepriseType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nom', TextType::class,
                ['required' => true]
            )
            ->add('activite', TextType::class,
                ['required' => true]
            )
            ->add('adresse' , AdresseType::class,
                ['required' => true]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
