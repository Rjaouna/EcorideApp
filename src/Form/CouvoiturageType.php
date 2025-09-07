<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Voiture;
use App\Entity\Couvoiturage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CouvoiturageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departAt', null, [
                'widget' => 'single_text'
            ])
            ->add('lieuDepart')
            ->add('arriveeAt', null, [
                'widget' => 'single_text'
            ])
            ->add('lieuArrivee')
            ->add('voiture', EntityType::class, [
                'class' => Voiture::class,
                'choice_label' => 'immatriculation',
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
