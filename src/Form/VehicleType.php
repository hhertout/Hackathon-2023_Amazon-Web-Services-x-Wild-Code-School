<?php

namespace App\Form;

use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class VehicleType extends AbstractType implements FormTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand', TextType::class,[
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('model', TextType::class,[
                'attr' => [
                    'class' => 'form-control mb-3 mb-3'
                ]
            ])
            ->add(
                'energy',
                ChoiceType::class,
                [
                    'choices' => [
                        'diesel' => 'diesel',
                        'electric' => 'electric',
                        'gazoline' => 'gasoline'
                    ],
                    'multiple' => false,
                    'expanded' => false,
                    'attr' => [
                        'class' => 'form-select mb-3',
                    ]
                ]
            )
            ->add('nbSeat', IntegerType::class,[
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('is_shared', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input mx-2 mb-3',
                ]
            ])
            ->add('is_kaput', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input mx-2 mb-3',
                ]
            ])
            ->add('immatriculation', TextType::class,[
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('autonomy', IntegerType::class,[
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add(
                'type',
                ChoiceType::class,
                [
                    'choices' => [
                        'utility' => 'utility',
                        'SUV' => 'SUV',
                        'urban' => 'urban',
                        'sedan' => 'sedan'
                    ],
                    'multiple' => false,
                    'expanded' => false,
                    'attr' => [
                        'class' => 'form-select mb-3',
                    ]
                ]
            )
            ->add(
                'gearbox',
                ChoiceType::class,
                [
                    'choices' => [
                        'manual' => 'manual',
                        'automatic' => 'automatic'
                    ],
                    'multiple' => false,
                    'expanded' => false,
                    'attr' => [
                        'class' => 'form-select mb-3',
                    ]
                ]
            )
            ->add('poster', TextType::class,[
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('isAvailable', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input mx-2 mb-4',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
