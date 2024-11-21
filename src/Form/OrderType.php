<?php

namespace App\Form;

use App\Entity\Store;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('pickUpStore', EntityType::class, [
                'label' => "Choisissez votre magasin de retrait",
                'required' => true,
                'class' => Store::class,
                'expanded' => true,
                'label_html' => true
            ])

            ->add('pickupDate', DateType::class,[
                'label'=> "Choisissez votre date de retrait",
                'widget' => 'choice',
                'input' => 'datetime_immutable',
                'data' => new \DateTimeImmutable('now'),
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\Callback(function ($date, ExecutionContextInterface $context) {
                        $currentDate = new \DateTimeImmutable();
                        $maxDate = (clone $currentDate)->add(new \DateInterval('P7D'));

                        if ($date < $currentDate) {
                            $context->buildViolation('La date ne peut pas être dans le passé.')
                                ->atPath('pickupDate')
                                ->addViolation();
                        }

                        if ($date > $maxDate) {
                            $context->buildViolation('La date ne peut pas dépasser 7 jours à partir d\'aujourd\'hui.')
                                ->atPath('pickupDate')
                                ->addViolation();
                        }
                        $dayOfWeek = $date->format('N');
                        if ($dayOfWeek == 1 || $dayOfWeek == 7) {
                            $context->buildViolation('La date ne peut pas être un lundi ou un dimanche.')
                                ->atPath('pickupDate')
                                ->addViolation();
                        }
                    }),
                ],
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'w-100 btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
     {
         $resolver->setDefaults([
             /*.'addresses' => null; */

                 ]
         );
     }

}
