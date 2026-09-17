<?php

namespace App\Form;

use App\Enum\TeamRole;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;

class ManualCheckinForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bib_number', NumberType::class)
            ->add('captain', EnumType::class, [
                'class' => TeamRole::class,
                'choice_attr' => ['class' => 'first-letter:uppercase'],
                'choice_label' => function ($choice, string $key): TranslatableMessage|string {
                    return match ($choice) {
                        TeamRole::CAPTAIN => "Capitaine",
                        TeamRole::TEAMMATE => "Équipier"
                    };
                },
                'expanded' => true,
                'multiple' => false,
                'label_attr' => ['class' => 'cursor-pointer'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => 'App\DTO\ManualCheckinDTO',
        ]);
    }
}
