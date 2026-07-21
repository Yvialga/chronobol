<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Trail;
use App\Entity\TrailTemplate;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('start_time', null, [
                'widget' => 'single_text',
            ])
            ->add('description')
            ->add('member_number')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trail::class,
        ]);
    }
}
