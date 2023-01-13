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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class VehicleType extends AbstractType implements FormTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('model', TextType::class, [
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
                        'gasoline' => 'gasoline'
                    ],
                    'multiple' => false,
                    'expanded' => false,
                    'attr' => [
                        'class' => 'form-select mb-3',
                    ]
                ]
            )
            ->add('nbDoor', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ]
            ])
            ->add('is_shared', ChoiceType::class, [
                'label' => 'The Vehicle can be rented by an other company ?',
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'choices' => [
                    'No' => false,
                    'Yes' => true,
                ],
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('is_kaput', ChoiceType::class, [
                'label' => "The vehicule is in maintenance ?",
                'attr' => [
                    'class' => 'form-control mb-3',
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
                    'class' => 'form-control mb-3',
                ]
            ])
            ->add('autonomy', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
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
            //->add('poster')
            ->add('isAvailable', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control mb-4',
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
