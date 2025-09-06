<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// Types de champs
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

// Contraintes
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // -------- OBLIGATOIRES (entité non-nullable) --------
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank(message: 'Veuillez saisir votre email.'),
                    new Assert\Email(message: 'Adresse email invalide.'),
                    new Assert\Length(max: 180),
                ],
            ])

            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new Assert\NotBlank(message: 'Veuillez saisir un mot de passe.'),
                    new Assert\Length(
                        min: 8,
                        minMessage: 'Votre mot de passe doit contenir au moins {{ limit }} caractères.',
                        max: 4096
                    ),
                ],
                'label' => 'Mot de passe',
            ])

            ->add('nom', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(message: 'Votre nom est requis.'),
                    new Assert\Length(max: 50),
                ],
            ])

            ->add('prenom', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(message: 'Votre prénom est requis.'),
                    new Assert\Length(max: 50),
                ],
            ])

            ->add('telephone', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(message: 'Votre téléphone est requis.'),
                    new Assert\Length(max: 50),
                ],
            ])

            ->add('adresse', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(message: 'Votre adresse est requise.'),
                    new Assert\Length(max: 255),
                ],
            ])

            ->add('naissanceAt', DateType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime_immutable', // correspond à ton champ \DateTimeImmutable
                'constraints' => [
                    new Assert\NotBlank(message: 'Votre date de naissance est requise.'),
                    new Assert\LessThan('today', message: 'La date de naissance doit être dans le passé.'),
                ],
                'label' => 'Date de naissance',
            ])

            ->add('pseudo', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(message: 'Votre pseudo est requis.'),
                    new Assert\Length(max: 50),
                ],
            ])

            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                    'Autre' => 'Autre',
                ],
                'placeholder' => 'Sélectionnez…',
                'constraints' => [
                    new Assert\NotBlank(message: 'Veuillez sélectionner votre sexe.'),
                ],
            ])

            // -------- OBLIGATOIRE (formulaire uniquement) --------
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new Assert\IsTrue(message: 'Vous devez accepter les conditions générales.'),
                ],
                'label' => 'J’accepte les conditions générales',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
