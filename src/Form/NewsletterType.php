<?php

namespace App\Form;

use App\Entity\Newsletter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titleOne', TextType::class, [
                'label' => "Titre 1",
                'required' => false,
                'attr' => ['class' => 'inputBorder w-100 text-center']
            ])
            ->add('descOne', TextareaType::class, [
                'label' => "Description ",
                'required' => false,
                'attr' => [
                        'class' => 'inputBorder w-100 text-center',
                        'style' => 'height:250px'
                    ]
            ])
            ->add('titleTwo', TextType::class, [
                'label' => "Titre 2",
                'required' => false,
                'attr' => ['class' => 'inputBorder w-100 text-center']
            ])
            ->add('descTwo', TextareaType::class, [
                'label' => "Description ",
                'required' => false,
                'attr' => [
                        'class' => 'inputBorder w-100 text-center',
                        'style' => 'height:250px'
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Newsletter::class,
        ]);
    }
}
