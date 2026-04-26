<?php

namespace App\Form\Type;

use App\Entity\InternalLocation;
use App\Entity\Lieu;
use App\Entity\OeuvreStockage;
use App\Service\Options;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationFilterType extends AbstractType
{
    private Options $options;

    public function __construct(Options $options)
    {
        $this->options= $options;
    }

    /**
     * @param FormBuilderInterface<FormBuilderInterface> $builder
     * @param array<string, mixed> $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => $this->options->getLocationTypes(),
                'placeholder' => ''
            ])
            ->add('precisions', ChoiceType::class, [
                'choices' => $this->options->getLocationDetails(),
                'placeholder' => '',
                'attr' => [
                    'data-depend-on' => 'filters_oeuvreStockages_type',
                    'data-depend-on-value' => '1'
                ]
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nom', 'ASC');
                },
                'placeholder' => '',
                'label' => 'Localisations externes',
                'attr' => [
                    'data-depend-on' => 'filters_oeuvreStockages_type',
                    'data-depend-on-value' => '1'
                ]
            ])
            ->add('internalLocation', EntityType::class, [
                'class' => InternalLocation::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.RoomLabel', 'ASC');
                },
                'placeholder' => '',
                'label' => 'Localisations internes',
                'attr' => [
                    'data-depend-on' => 'filters_oeuvreStockages_type',
                    'data-depend-on-value' => '0'
                ]
            ])
            ->add('description', TextareaType::class);
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OeuvreStockage::class
        ]);
    }
}
