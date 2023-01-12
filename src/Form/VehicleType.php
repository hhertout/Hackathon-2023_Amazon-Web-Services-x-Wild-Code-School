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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;

class VehicleType extends AbstractType implements FormTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand', TextType::class)
            ->add('model', TextType::class)
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
                ]
            )
            ->add('nbSeat', IntegerType::class)
            ->add('is_shared', RadioType::class)
            ->add('is_kaput', RadioType::class)
            ->add('immatriculation', TextType::class)
            ->add('autonomy', IntegerType::class)
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
                ]
            )
            ->add('poster')
            ->add('isAvailable', RadioType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
