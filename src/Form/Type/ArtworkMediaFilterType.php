<?php

namespace App\Form\Type;

use App\Entity\ArtworkMedia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtworkMediaFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', ChoiceType::class, [
                'label' => 'Média',
                'choices' => [
                    'Oeuvres avec média' => '1',
                    'Oeuvres sans média' => '0'
                ],
                'placeholder' => '',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArtworkMedia::class
        ]);
    }
}
