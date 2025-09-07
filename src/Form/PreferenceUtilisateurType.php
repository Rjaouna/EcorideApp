<?php

namespace App\Form;

use App\Entity\PreferenceUtilisateur;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreferenceUtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('autoriseNourriture', ChoiceType::class, [
                'label'    => 'Nourriture',
                'expanded' => true,
                'multiple' => false,
                'choices'  => [
                    'Oui'        => 'oui',
                    'Non'        => 'non',
                ],
                'choice_translation_domain' => false,
            ])

            ->add('autoriseBoissons', ChoiceType::class, [
                'label'    => 'Boissons',
                'expanded' => true,
                'multiple' => false,
                'choices'  => [
                    'Oui'        => 'oui',
                    'Non'        => 'non',
                ],
                'choice_translation_domain' => false,
            ])

            ->add('politiqueTabac', ChoiceType::class, [
                'label'    => 'Fumeur',
                'expanded' => true,  
                'multiple' => false,
                'choices'  => [
                    'Autorisé'   => 'autoriser',
                    'Interdit'   => 'interdire',
                    'À discuter' => 'discuter',
                ],
                'choice_translation_domain' => false,
            ])

            ->add('politiqueAnimaux', ChoiceType::class, [
                'label'    => 'Animaux',
                'expanded' => true,
                'multiple' => false,
                'choices'  => [
                    'Autorisé'   => 'autoriser',
                    'Interdit'   => 'interdire',
                    'À discuter' => 'discuter',
                ],
                'choice_translation_domain' => false,
            ])

            ->add('niveauConversation', ChoiceType::class, [
                'label'    => 'Niveau de conversation',
                'expanded' => true,
                'multiple' => false,
                'choices'  => [
                    'Discret' => 'discret',
                    'Normal'  => 'normal',
                    'Bavard'  => 'bavard',
                ],
                'choice_translation_domain' => false,
            ])

            ->add('niveauMusique', ChoiceType::class, [
                'label'    => 'Niveau de musique',
                'expanded' => true,
                'multiple' => false,
                'choices'  => [
                    'Faible'  => 'faible',
                    'Moyenne' => 'moyenne',
                    'Forte'   => 'forte',
                ],
                'choice_translation_domain' => false,
            ])

            ->add('autoriseNourriture', ChoiceType::class, [
                'label'    => 'Nourriture autorisée',
                'expanded' => true,
                'multiple' => false,
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])

            ->add('autoriseBoissons', ChoiceType::class, [
                'label'    => 'Boissons autorisées',
                'expanded' => true,
                'multiple' => false,
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])

            ->add('tailleMaxBagages', ChoiceType::class, [
                'label'    => 'Taille max des bagages',
                'expanded' => true,
                'multiple' => false,
                'choices'  => [
                    '5 Kg'  => '5',
                    '10 Kg' => '10',
                    '15 Kg'  => '15',
                ],
                'choice_translation_domain' => false,
            ])

         
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PreferenceUtilisateur::class,
        ]);
    }
}
