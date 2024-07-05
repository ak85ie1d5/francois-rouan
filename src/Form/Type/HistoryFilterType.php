<?php

namespace App\Form\Type;

use App\Entity\OeuvreHistorique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoryFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('unmappedDescription', ChoiceType::class, [
                'label' => 'Description',
                'choices' => [
                    'Oeuvres avec description' => '1',
                    'Oeuvres sans description' => '0'
                ],
                'placeholder' => '',
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'rows' => 5
                ]
            ]);


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OeuvreHistorique::class
        ]);
    }
}
