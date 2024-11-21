<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;


class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => "Prénom",
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 30
                    ])
                ],
                'attr' =>[
                    'placeholder'=>"Prénom"
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => "Nom",
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 30
                    ])
                ],
                'attr' =>[
                    'placeholder'=>"Nom de famille"
                ]
            ])

            ->add('email', EmailType::class, [
                'label'=> "E-mail: ",
                'attr' =>[
                    'placeholder'=>"Adresse mail valide"
                ],
            ])

            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min'=> 8,
                        'max'=>30
                    ])
                ],
                'first_options'  => ['label' => 'Votre mot de passe',
                    'attr' =>[
                        'placeholder'=>"Choisissez un mot de passe avec au minimum 8 caractères, dont une majuscule et un symbole"
                    ],
                    'hash_property_path' => 'password'],
                'second_options' => ['label' => 'Confirmation mot de passe',
                    'attr' =>[
                        'placeholder'=>"Confirmez votre mot de passe"
                    ]],
                'mapped' => false,
            ])

            ->add('address', TextType::class, [
                'label' => "Adresse",
                'constraints' => [
                    new Length([
                        'min' =>5,
                        'max' => 30
                    ])
                ],
                'attr' =>[
                    'placeholder'=>"Adresse"
                ]
            ])
            ->add('postal', NumberType::class, [
                'label' => "Code Postal",
                'constraints' => [
                    new Length([
                        'min' =>5,
                        'max' => 6
                    ])
                ],
                'attr' =>[
                    'placeholder'=>"Code Postal"
                ]
            ])

            ->add('city', TextType::class, [
                'label' => "Ville",
                'constraints' => [
                    new Length([
                        'min' =>3,
                        'max' => 30
                    ])
                ],
                'attr' =>[
                    'placeholder'=>"Ville"
                ]
            ])

            ->add('submit', SubmitType::class,[
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => [
                new UniqueEntity([
                    'entityClass' => User::class,
                    'fields' => 'email'
                ])
            ],
            'data_class' => Customer::class,
        ]);
    }
}

