<?php

namespace App\Form;

use App\Entity\Marque;
use App\Entity\Voiture;
use App\Repository\MarqueRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Marque triée alphabétiquement
            ->add('marque', EntityType::class, [
                'class' => Marque::class,
                'choice_label' => 'nom',
                'query_builder' => function (MarqueRepository $repo) {
                    return $repo->createQueryBuilder('m')->orderBy('m.nom', 'ASC');
                },
                'placeholder' => 'Sélectionnez une marque',
                'attr' => ['class' => 'form-select'],
            ])

            ->add('modele', null, [
                'attr' => ['placeholder' => 'Ex. 308, Clio, Model 3'],
            ])
            ->add('nombrePlaces', ChoiceType::class, [
                'label' => 'Nombre de places',
                'placeholder' => 'Sélectionnez…',
                'choices' => [
                    '1 place'  => 1,
                    '2 places' => 2,
                    '3 places' => 3,
                    '4 places' => 4,
                    '5 places' => 5,
                ],
                'choice_translation_domain' => false,
            ])

            ->add('immatriculation', null, [
                'attr' => ['placeholder' => 'Ex. AA-123-BB'],
            ])

            // Liste des énergies
            ->add('energie', ChoiceType::class, [
                'placeholder' => 'Sélectionnez une énergie',
                'choices' => [
                    'Essence' => 'essence',
                    'Diesel' => 'diesel',
                    'Hybride' => 'hybride',
                    'Hybride rechargeable (PHEV)' => 'hybride_rechargeable',
                    'Électrique' => 'electrique',
                    'GPL' => 'gpl',
                    'GNV' => 'gnv',
                ],
                'preferred_choices' => ['essence', 'diesel', 'electrique'],
                'choice_translation_domain' => false,
                'attr' => ['class' => 'form-select'],
            ])

            // Couleurs courantes
            ->add('couleur', ChoiceType::class, [
                'placeholder' => 'Sélectionnez une couleur',
                'choices' => [
                    'Blanc' => 'Blanc',
                    'Noir' => 'Noir',
                    'Gris' => 'Gris',
                    'Argent' => 'Argent',
                    'Bleu' => 'Bleu',
                    'Rouge' => 'Rouge',
                    'Vert' => 'Vert',
                    'Beige' => 'Beige',
                    'Orange' => 'Orange',
                    'Jaune' => 'Jaune',
                    'Marron' => 'Marron',
                    'Violet' => 'Violet',
                ],
                'preferred_choices' => ['Blanc', 'Noir', 'Gris', 'Bleu', 'Rouge'],
                'choice_translation_domain' => false,
                'attr' => ['class' => 'form-select'],
            ])

            ->add('immatriculationAt', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
