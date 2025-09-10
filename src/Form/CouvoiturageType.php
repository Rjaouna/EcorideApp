<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Voiture;
use App\Entity\Couvoiturage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CouvoiturageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departAt', null, [
                'widget' => 'single_text'
            ])
            ->add('lieuDepart', ChoiceType::class, [
                'label'       => 'Ville de départ',
                'placeholder' => '— Ville (France) —',
                'required'    => true,
                'choices'     => [
                    'Paris' => 'Paris',
                    'Marseille' => 'Marseille',
                    'Lyon' => 'Lyon',
                    'Toulouse' => 'Toulouse',
                    'Nice' => 'Nice',
                    'Nantes' => 'Nantes',
                    'Strasbourg' => 'Strasbourg',
                    'Montpellier' => 'Montpellier',
                    'Bordeaux' => 'Bordeaux',
                    'Lille' => 'Lille',
                ],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('lieuArrivee', ChoiceType::class, [
                'label'       => 'Ville de arrivee',
                'placeholder' => '— Ville (France) —',
                'required'    => true,
                'choices'     => [
                    'Paris' => 'Paris',
                    'Marseille' => 'Marseille',
                    'Lyon' => 'Lyon',
                    'Toulouse' => 'Toulouse',
                    'Nice' => 'Nice',
                    'Nantes' => 'Nantes',
                    'Strasbourg' => 'Strasbourg',
                    'Montpellier' => 'Montpellier',
                    'Bordeaux' => 'Bordeaux',
                    'Lille' => 'Lille',
                ],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('arriveeAt', null, [
                'widget' => 'single_text'
        ])
            ->add('voiture', EntityType::class, [
                'class' => Voiture::class,
                'choice_label' => 'immatriculation',
            'placeholder'  => '— Sélectionnez une voiture —',
            ])
            ->add('nbPlace')
            ->add('prixPersonne')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Couvoiturage::class,
        ]);
    }
}
