<?php

namespace App\Form;

use App\Entity\Trail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrailForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'input',
                ]
            ])
            ->add('start_time', TimeType::class, [
                'label' => 'Heure de départ',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'input',
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'input',
                ],
                'required' => false,
            ])
            ->add('member_number', NumberType::class, [
                'disabled' => true,
                'attr' => [
                    'class' => 'input',
                    'value' => 2
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trail::class,
        ]);
    }
}
