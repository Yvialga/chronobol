<?php

namespace App\Form;

use App\Entity\Runner;
use App\Entity\Team;
use App\Enum\GenderEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RunnerForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('age', DateType::class)
            ->add('gender', EnumType::class, [
                'class' => GenderEnum::class,
                'choices' => [
                    'Homme' => GenderEnum::man,
                    'Femme' => GenderEnum::woman,
                    'Autre' => GenderEnum::other,
                ]
            ])
            ->add('email', EmailType::class)
            ->add('bib_number', NumberType::class)
            ->add('chip_id', TextType::class)
            ->add('is_captain', CheckboxType::class)
            ->add('is_underage', CheckboxType::class)
            ->add('medical_certificate', TextType::class)
            ->add('parental_consent', CheckboxType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Runner::class,
        ]);
    }
}
