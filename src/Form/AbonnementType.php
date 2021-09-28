<?php

namespace App\Form;

use App\Entity\Abonnement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AbonnementType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        // NOM DE l'ABONNEMENT
            ->add('title', ChoiceType::class,[
                'choices' => [  'Demandeur d\'emploi' => true,
                                'Entreprise' => true,
                                'Pack Etudiant' => true,
                                'Solidarité' => true
                            ],
                'label' => 'Intitulé',
                'attr' => [ 'class' => 'inputTitle',
                            'input' => 'title',
                            'id' => 'intitule',
                            'name' => 'intitule']
            ])

        // PRIX DE l'ABONNEMENT
            ->add('price', ChoiceType::class,[
                'choices' => [  '49,99€' => true,
                                '49,99€' => true,
                                '49,99€' => true,
                                '59,99€' => true 
                            ],
                'label' =>  'Prix',
                'attr' => [ 'class' => 'inputTitle w-100',
                            'input' => 'title',
                            'id' => 'price',
                            'name' => 'price']
            ])

        // DESCRIPTION DE L'ABONNEMENT
            ->add('description', TextareaType::class,[
                'attr' => [ 'class' => 'txtArea w-100',
                            'id' => 'description'],
                
            ])

        // DATE DE DEBUT DE L'ABONNEMENT
            ->add('createdAt', DateType::class,[
                'widget' => 'single_text',
                'label' => 'Date de début',
            ])

        // DATE DE FIN DE L'ABONNEMENT
            ->add('status', DateType::class,[
                'widget' => 'single_text',
                'label' => 'Date de fin',
            ])

        // BOUTTON DE VALIDATION
            ->add('valider', SubmitType::class,[
                'label' => 'Valider',
                'attr' => [ 'class'=>'btn btn-primary',
                            'type' => 'hidden']
            ])

        // CREATION DE LA FORME "SIMPLIFIE" DE L'ABONNEMENT
            ->getForm()
            ;
    }


    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults([
            'data_class' => Abonnement::class,
        ]);
    }
}
