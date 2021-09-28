<?php

namespace App\Form;

use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CommentairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contenu')
            ->add('rating', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 5,
                    'step' => 1
                ]
            ])
            // ->add('rgpd', CheckboxType::class, [
            //     'label' => 'J\'accepte que mes informations soient stockées pour la gestion des commentaires. J\'ai bien noté qu\'en aucun cas ces données ne seront cédées à des tiers.'
            //     ])
            // ->add('user')
            // ->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
