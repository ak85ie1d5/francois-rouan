<?php

namespace App\Form\Type;

use App\Entity\Lieu;
use App\Entity\OeuvreStockage;
use App\Service\Options;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class locationFilterType extends AbstractType
{
    private Options $options;

    public function __construct(Options $options)
    {
        $this->options= $options;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => $this->options->getLocationTypes(),
                'placeholder' => ''
            ])
            ->add('precisions', ChoiceType::class, [
                'choices' => $this->options->getLocationDetails(),
                'placeholder' => ''
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'placeholder' => ''
            ])
            ->add('description', TextareaType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OeuvreStockage::class
        ]);
    }
}
