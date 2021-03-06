<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AdresseType extends ApplicationType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('codePostal', TextType::class, [
                'required' => true
            ])
            ->add('numeroRue', TextType::class, [
                'required' => true,
            ])
            ->add('nomRue', TextType::class, [
                'required' => true
            ])
            ->add('ville', TextType::class, [
                'required' => true
            ])
            ->add('region', ChoiceType::class, [
                'required' => true,
                'choices'  => [
                    'Hauts-de-france'  => [
                        'Aisne'         => 'Aisne',
                        'Nord'          => 'Nord',
                        'Oise'          => 'Oise',
                        'Somme'         => 'Somme',
                        'Pas-de-calais' => 'Pas-de-calais'
                    ],
                    'Grand est'=> [
                        'Aube'               => 'Aube',
                        'Marne'              => 'Marne',
                        'Meuse'              => 'Meuse',
                        'Vosges'             => 'Vosges',
                        'Moselle'            => 'Moselle',
                        'Bas-Rhin'           => 'Bas-Rhin',
                        'Ardennes'           => 'Ardennes',
                        'Haut-Rhin'          => 'Haut-Rhin',
                        'Haute-Marne'        => 'Haute-Marne',
                        'Meurthe-et-Moselle' => 'Meurthe-et-Moselle'
                    ],
                    'Avergne-rh??nes-alpes'=> [
                        'Ain'          => 'Ain',
                        'Dr??me'        => 'Dr??me',
                        'Is??re'        => 'Is??re',
                        'Rh??ne'        => 'Rh??ne',
                        'Allier'       => 'Allier',
                        'Cantal'       => 'Cantal',
                        'Savoie'       => 'Savoie',
                        'Ard??che'      => 'Ard??che',
                        'Haute-Loire'  => 'Haute-Loire',
                        'Puy-de-D??me'  => 'Puy-de-D??me',
                        'Haute-Savoie' => 'Haute-Savoie'
                    ],
                    'Provence-alpes-c??te d\'azur' => [
                        'Var'                     => 'Var',
                        'Vaucluse'                => 'Vaucluse',
                        'Hautes-Alpes'            => 'Hautes-Alpes',
                        'Alpes-Maritimes'         => 'Alpes-Maritimes',
                        'Bouches-du-Rh??nes'       => 'Bouches-du-Rh??nes',
                        'Alpes-de-Haute-Provence' => 'Alpes-de-Haute-Provence'
                    ],
                    'Occitanie' => [
                        'Lot'                 => 'Lot',
                        'Aude'                => 'Aude',
                        'Gard'                => 'Gard',
                        'Tarn '               => 'Tarn ',
                        'Loz??re'              => 'Loz??re',
                        'Ari??ge'              => 'Ari??ge',
                        'Aveyron'             => 'Aveyron',
                        'H??rault'             => 'H??rault',
                        'Haute-Garonne'       => 'Haute-Garonne',
                        'Hautes-Pyr??n??es'     => 'Hautes-Pyr??n??es',
                        'Tarn-et-Garonne'     => 'Tarn-et-Garonne',
                        'Pyr??n??es-Orientales' => 'Pyr??n??es-Orientales'
                    ],
                    'Nouvelle aquitaine' => [
                        'Creuse'               => 'Creuse',
                        'Landes'               => 'Landes',
                        'Vienne'               => 'Vienne',
                        'Gironde'              => 'Gironde',
                        'Corr??ze'              => 'Corr??ze',
                        'Charante'             => 'Charante',
                        'Dordogne'             => 'Dordogne',
                        'Deux-S??vres'          => 'Deux-S??vres',
                        'Haute-vienne'         => 'Haute-vienne',
                        'Lot-et-Garonne'       => 'Lot-et-Garonne',
                        'Charante-Maritime'    => 'Charante-Maritime',
                        'Pyr??n??es-Atlantiques' => 'Pyr??n??es-Atlantiques'
                    ],
                    'Pays de la loire' => [
                        'Vend??e'           => 'Vend??e',
                        'Sarthe'           => 'Sarthe',
                        'Mayenne'          => 'Mayenne',
                        'Maine-et-Loire'   => 'Maine-et-Loire',
                        'Loire-Atlantique' => 'Loire-Atlantique'
                    ],
                    '??le-de-france' => [
                        'Paris'             => 'Paris',
                        'Essone'            => 'Essone',
                        'Yvelines'          => 'Yvelines',
                        'Val-d\'Oise'       => 'Val-d\'Oise',
                        'Hauts-de-Seine'    => 'Hauts-de-Seine',
                        'Seine-et-Marne'    => 'Seine-et-Marne',
                        'Seine-Saint-Denis' => 'Seine-Saint-Denis',
                    ],
                    'Bretagne' => [
                        'Finist??re'       => 'Finist??re',
                        'C??tes-d\'Armor'  => 'C??tes-d\'Armor',
                        'Morbihan'        => 'Morbihan',
                        'Ille-et-Vilaine' => 'Ille-et-Vilaine'
                    ],
                    'Normandie' => [
                        'Eure'           => 'Eure',
                        'Orne'           => 'Orne',
                        'Manche'         => 'Manche',
                        'Calvados'       => 'Calvados',
                        'Seine-Maritime' => 'Seine-Maritime'
                    ],
                    'Bourgogne-franche-comt??' => [
                        'Jura'                  => 'Jura',
                        'Doubs'                 => 'Doubs',
                        'Yonne'                 => 'Yonne',
                        'Ni??vre'                => 'Ni??vre',
                        'C??te-d\'Or'            => 'C??te-d\'Or',
                        'Haute-Sa??ne'           => 'Haute-Sa??ne',
                        'Sa??ne-et-Loire'        => 'Sa??ne-et-Loire',
                        'Terriroire de Belfort' => 'Terriroire de Belfort'
                    ],
                    'centre-val de loire' => [
                        'Cher'           => 'Cher',
                        'Indre'          => 'Indre',
                        'Loiret'         => 'Loiret',
                        'Loir-et-Cher'   => 'Loir-et-Cher',
                        'Eure-et-Loire'  => 'Eure-et-Loire',
                        'Indre-et-Loire' => 'Indre-et-Loire'
                    ],
                    'Corse' => [
                        'Haute Corse'  => 'Haute Corse',
                        'Corse du sud' => 'Corse du sud'
                    ]
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
