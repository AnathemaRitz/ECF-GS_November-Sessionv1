<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;


class PasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actualPassword', PasswordType::class,[
                'label' => 'Mot de passe actuel: ',
                'attr'=>
                    ['placeholder' => 'Entrez votre de passe actuel'],
                'mapped' => false
            ],
            )

            ->add('plainPassword', RepeatedType::class,[
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min'=> 4,
                        'max'=>30
                    ])
                ],
                'first_options'  => ['label' => 'Nouveau mot de passe: ',
                    'attr' =>[
                        'placeholder'=>"Choisissez un mot de passe avec au minimum 8 caractères, dont une majuscule et un symbole"
                    ],
                    'hash_property_path' => 'password'],
                'second_options' => ['label' => 'Confirmation nouveau mot de passe: ',
                    'attr' =>[
                        'placeholder'=>"Confirmez votre nouveau mot de passe"
                    ]],
                'mapped' => false,
            ])

            ->add('submit', SubmitType::class,[
                'label' => 'Confirmation',
                'attr' => [
                    'class' => 'btn btn-success'
                ]])


            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                $form = $event->getForm();
                $user = $form->getConfig()->getOptions()['data'];
                $passwordHasher = $form->getConfig()->getOptions()['passwordHasher'];


                $isValid = $passwordHasher->isPasswordValid(
                    $user,
                    $form->get('actualPassword')->getData()
                );

                if (!$isValid) {
                    $form->get('actualPassword')->addError(new FormError('Mot de passe actuel incorrect'));
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'passwordHasher'=>null,
        ]);

    }
}
