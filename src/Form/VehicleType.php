<?php

namespace App\Form;

use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
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
            ->add('brand', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('model', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add(
                'energy',
                ChoiceType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'choices' => [
                        'diesel' => 'diesel',
                        'electric' => 'electric',
                        'gazoline' => 'gasoline'
                    ],
                    'multiple' => false,
                    'expanded' => false,
                ]
            )
            ->add('nbSeat', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('is_shared', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'choices' => [
                    'No' => false,
                    'Yes' => true,
                ],
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('is_kaput', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'choices' => [
                    'No' => false,
                    'Yes' => true,
                ],
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('immatriculation', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('autonomy', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add(
                'type',
                ChoiceType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'choices' => [
                        'utility' => 'utility',
                        'SUV' => 'SUV',
                        'urban' => 'urban',
                        'sedan' => 'sedan'
                    ],
                    'multiple' => false,
                    'expanded' => false,
                ]
            )
            ->add(
                'gearbox',
                ChoiceType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'choices' => [
                        'manual' => 'manual',
                        'automatic' => 'automatic'
                    ],
                    'multiple' => false,
                    'expanded' => false,
                ]
            )
            //->add('poster')
            ->add('isAvailable', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'choices' => [
                    'No' => false,
                    'Yes' => true,
                ],
                'multiple' => false,
                'expanded' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
