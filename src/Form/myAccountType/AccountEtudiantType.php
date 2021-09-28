<?php

namespace App\Form\MyAccountType;

use App\Entity\Etudiant;
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

class AccountEtudiantType extends AbstractType {
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
            ->add('schoolName', TextType::class, [
                'required' => true
            ])
            ->add('lvlOfStudies', ChoiceType::class,[
                'required' => true,
                'multiple' => false,
                'choices'  => [
                    'Aucun dîplome'                                                                                                    => 'Aucun dîplome',
                    'CAP, BEP'                                                                                                         => 'CAP, BEP',
                    'Baccalauréat (BAC)'                                                                                               => 'Baccalauréat',
                    'DEUG, BTS, DUT, DEUST (BAC+2)'                                                                                    => 'DEUG, BTS, DUT, DEUST',
                    'Licence, licence professionnelle (BAC+3)'                                                                         => 'Licence, licence professionnelle',
                    'Maîtrise, master 1 (BAC+4)'                                                                                       => 'Maîtrise, master 1',
                    'Master, diplôme d\'études approfondies, diplôme d\'études supérieures spécialisées, diplôme d\'ingénieur (BAC+5)' => 'Master, diplôme d\'études approfondies, diplôme d\'études supérieures spécialisées, diplôme d\'ingénieur',
                    'Doctorat, habilitation à diriger des recherches (BAC+8)'                                                          => 'Doctorat, habilitation à diriger des recherches'
                ]
            ])
            ->add('domainStudies', ChoiceType::class,[
                'required' => true,
                'multiple' => false,
                'choices'  => [
                    'Agriculture, environnement, agroalimentaire'          => 'Agriculture, environnement, agroalimentaire',
                    'Arts, arts appliqués, culture'                        => 'Arts, arts appliqués, culture',
                    'Commerce, tourisme, hôtellerie'                       => 'Commerce, tourisme, hôtellerie',
                    'Gestion de production, qualité'                       => 'Gestion de production, qualité',
                    'Information, communication'                           => 'Information, communication',
                    'Lettres, langues vivantes, sciences humaines'         => 'Lettres, langues vivantes, sciences humaines',
                    'Maintenance, matériaux'                               => 'Maintenance, matériaux',
                    'Physique, chimie, biologie'                           => 'Physique, chimie, biologie',
                    'Sciences, technologies'                               => 'Sciences, technologies',
                    'Animation, sport'                                     => 'Animation, sport',
                    'Bâtiment, travaux publics'                            => 'Bâtiment, travaux publics',
                    'Droit, économie, gestion, comptabilité'               => 'Droit, économie, gestion, comptabilité',
                    'Informatique, électronique, électricité, énergétique' => 'Informatique, électronique, électricité, énergétique',
                    'Logistique, transport'                                => 'Logistique, transport',
                    'Mécanique, microtechnique'                            => 'Mécanique, microtechnique',
                    'Santé, social'                                        => 'Santé, social',
                    'Sécurité, hygiène'                                    => 'Sécurité, hygiène',
                    'Bois, ameublement'                                    => 'Bois, ameublement'
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
