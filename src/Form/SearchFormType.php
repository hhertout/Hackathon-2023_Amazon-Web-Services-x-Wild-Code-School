<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class SearchFormType extends AbstractType implements FormTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', DateTimeType::class, [
                'label' => 'Starting Date'
            ])
            ->add('endDate', DateTimeType::class, [
                'label' => 'End Date'
            ])
            ->add('Brand', ChoiceType::class, [
                'choices' => [
                    'All' => null,
                    'Peugeot' => 'Peugeot',
                    'Citroën' => 'Citroën',
                    'Renault' => 'Renault',
                    'Volkswagen' => 'Volkswagen',
                    'BMW' => 'BMW',
                    'Mercedes' => 'Mercedes',
                    'Hyundai' => 'Hyundai',
                    'Audi' => 'Audi',
                    'Opel' => 'Opel',
                    'Toyota' => 'Toyota',
                    'Ford' => 'Ford',
                    'Honda' => 'Honda',
                    'DS' => 'DS',
                ],
                'attr' => [
                    'label' => 'Brand',
                ],
                'required'   => false,
            ])
            ->add('energy', ChoiceType::class, [
                'choices' => [
                    'All' => null,
                    'Diesel' => 'Diesel',
                    'Electric' => 'Electric',
                    'Gasoline' => 'gasoline'
                ],
                'multiple' => false,
                'expanded' => false,
                'required'   => false,
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}