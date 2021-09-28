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
                    'Avergne-rhônes-alpes'=> [
                        'Ain'          => 'Ain',
                        'Drôme'        => 'Drôme',
                        'Isère'        => 'Isère',
                        'Rhône'        => 'Rhône',
                        'Allier'       => 'Allier',
                        'Cantal'       => 'Cantal',
                        'Savoie'       => 'Savoie',
                        'Ardèche'      => 'Ardèche',
                        'Haute-Loire'  => 'Haute-Loire',
                        'Puy-de-Dôme'  => 'Puy-de-Dôme',
                        'Haute-Savoie' => 'Haute-Savoie'
                    ],
                    'Provence-alpes-côte d\'azur' => [
                        'Var'                     => 'Var',
                        'Vaucluse'                => 'Vaucluse',
                        'Hautes-Alpes'            => 'Hautes-Alpes',
                        'Alpes-Maritimes'         => 'Alpes-Maritimes',
                        'Bouches-du-Rhônes'       => 'Bouches-du-Rhônes',
                        'Alpes-de-Haute-Provence' => 'Alpes-de-Haute-Provence'
                    ],
                    'Occitanie' => [
                        'Lot'                 => 'Lot',
                        'Aude'                => 'Aude',
                        'Gard'                => 'Gard',
                        'Tarn '               => 'Tarn ',
                        'Lozère'              => 'Lozère',
                        'Ariège'              => 'Ariège',
                        'Aveyron'             => 'Aveyron',
                        'Hérault'             => 'Hérault',
                        'Haute-Garonne'       => 'Haute-Garonne',
                        'Hautes-Pyrénées'     => 'Hautes-Pyrénées',
                        'Tarn-et-Garonne'     => 'Tarn-et-Garonne',
                        'Pyrénées-Orientales' => 'Pyrénées-Orientales'
                    ],
                    'Nouvelle aquitaine' => [
                        'Creuse'               => 'Creuse',
                        'Landes'               => 'Landes',
                        'Vienne'               => 'Vienne',
                        'Gironde'              => 'Gironde',
                        'Corrèze'              => 'Corrèze',
                        'Charante'             => 'Charante',
                        'Dordogne'             => 'Dordogne',
                        'Deux-Sèvres'          => 'Deux-Sèvres',
                        'Haute-vienne'         => 'Haute-vienne',
                        'Lot-et-Garonne'       => 'Lot-et-Garonne',
                        'Charante-Maritime'    => 'Charante-Maritime',
                        'Pyrénées-Atlantiques' => 'Pyrénées-Atlantiques'
                    ],
                    'Pays de la loire' => [
                        'Vendée'           => 'Vendée',
                        'Sarthe'           => 'Sarthe',
                        'Mayenne'          => 'Mayenne',
                        'Maine-et-Loire'   => 'Maine-et-Loire',
                        'Loire-Atlantique' => 'Loire-Atlantique'
                    ],
                    'Île-de-france' => [
                        'Paris'             => 'Paris',
                        'Essone'            => 'Essone',
                        'Yvelines'          => 'Yvelines',
                        'Val-d\'Oise'       => 'Val-d\'Oise',
                        'Hauts-de-Seine'    => 'Hauts-de-Seine',
                        'Seine-et-Marne'    => 'Seine-et-Marne',
                        'Seine-Saint-Denis' => 'Seine-Saint-Denis',
                    ],
                    'Bretagne' => [
                        'Finistère'       => 'Finistère',
                        'Côtes-d\'Armor'  => 'Côtes-d\'Armor',
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
                    'Bourgogne-franche-comté' => [
                        'Jura'                  => 'Jura',
                        'Doubs'                 => 'Doubs',
                        'Yonne'                 => 'Yonne',
                        'Nièvre'                => 'Nièvre',
                        'Côte-d\'Or'            => 'Côte-d\'Or',
                        'Haute-Saône'           => 'Haute-Saône',
                        'Saône-et-Loire'        => 'Saône-et-Loire',
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
