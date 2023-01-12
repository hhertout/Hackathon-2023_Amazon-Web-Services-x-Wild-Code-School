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
                'label' => 'Starting Date',
                'attr'   => ['min' => ( new \DateTime() )->format('Y-m-d H:i')],
                'widget' => 'single_text',
            ])
            ->add('endDate', DateTimeType::class, [
                'label' => 'End Date',
                'attr'   => ['min' => ( new \DateTime() )->format('Y-m-d H:i')],
                'widget' => 'single_text',
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
            ])
            ->add('gearbox', ChoiceType::class, [
                'choices' => [
                    'All' => null,
                    'Automatic' => 'Automatic',
                    'Manual' => 'Manual',
                ],
                'multiple' => false,
                'expanded' => false,
                'required' => false,
            ])
            ->add('door', ChoiceType::class, [
                'choices' => [
                    'All' => null,
                    '3' => '3',
                    '5' => '5',
                ],
                'multiple' => false,
                'expanded' => false,
                'required' => false,
            ])
            ->add('shared', ChoiceType::class, [
                'choices' => [
                    'No' => false,
                    'Yes' => true,
                ],
                'multiple' => false,
                'expanded' => false,
                'label' => 'Show Shared Vehicle',
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}