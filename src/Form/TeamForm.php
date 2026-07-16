<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\Trail;
use App\Enum\CategoryEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;

class TeamForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', EnumType::class, [
                'class' => CategoryEnum::class,
                'choice_attr' => ['class' => 'first-letter:uppercase'],
                'choice_label' => function ($choice, string $key): TranslatableMessage|string {

                    return match ($choice) {
                        CategoryEnum::woman => 'Femme',
                        CategoryEnum::man => 'Homme',
                        CategoryEnum::mixed => 'Mixte',
                        default => strtoupper($key),
                    };
                },
                'expanded' => true,
                'label' => 'Catégorie',
                'label_attr' => ['class' => 'cursor-pointer'],
            ])
            ->add('paid_registration', CheckboxType::class, [
                'label' => 'Inscription payée',
                'required' => false,
                'attr' => ['class' => 'checkbox'],
                'label_attr' => ['class' => 'cursor-pointer'],
            ])
            ->add('deposit', CheckboxType::class, [
                'label' => 'Caution déposée',
                'required' => false,
                'attr' => ['class' => 'checkbox'],
                'label_attr' => ['class' => 'cursor-pointer'],
            ])
            ->add('electric_bike', CheckboxType::class, [
                'label' => 'Vélo électrique',
                'required' => false,
                'attr' => ['class' => 'checkbox'],
                'label_attr' => ['class' => 'cursor-pointer'],
            ])
            ->add('meal_count', NumberType::class, [
                'label' => 'Repas supplémentaires',
                'required' => false,
                'attr' => ['class' => 'input'],
                'label_attr' => ['class' => 'cursor-pointer'],
            ])
            ->add('fk_trail_id', EntityType::class, [
                'label' => 'Parcours',
                'attr' => ['class' => 'select validator'],
                'class' => Trail::class,
                'choice_label' => 'name',
                'choice_attr' => function ($choice, $key) {
                    return ['class' => 'capitalize'];
                },
                'label_attr' => ['class' => 'cursor-pointer'],
            ])
        ;
        $builder->add('runners', CollectionType::class, [
                'entry_type' => RunnerForm::class,
                'entry_options' => ['label' => false],
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
