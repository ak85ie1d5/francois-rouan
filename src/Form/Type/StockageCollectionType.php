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
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockageCollectionType extends AbstractType
{
    private Options $options;

    public function __construct(Options $options)
    {
        $this->options = $options;
    }

    /**
     * @param FormBuilderInterface<FormBuilderInterface> $builder
     * @param array<string, mixed> $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FirstDay', ChoiceType::class, [
                'choices' => $this->options->getDayNumeric(),
                'label' => 'Jour',
                'placeholder' => ''
            ])
            ->add('FirstMonth', ChoiceType::class, [
                'choices' => $this->options->getMonthTextual(),
                'label' => 'Mois',
                'placeholder' => ''
            ])
            ->add('FirstYear', IntegerType::class, [
                'label' => 'Année',
                'label_attr' => [
                    'aria-sort-default' => 'desc'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'choices' => $this->options->getLocationTypes(),
                'placeholder' => ''
            ])
            ->add('precisions', ChoiceType::class, [
                'choices' => $this->options->getLocationDetails(),
                'attr' => [
                    'data-depend-on' => "Oeuvre_oeuvreStockages_0_type",
                    'data-depend-on-value' => '1',
                ],
                'placeholder' => ''
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nom', 'ASC');
                },
                'attr' => [
                    'data-depend-on' => "Oeuvre_oeuvreStockages_0_type",
                    'data-depend-on-value' => '1',
                ],
                'label' => 'Lieu externes',
                'choice_label' => 'nom',
                'placeholder' => '',
            ])
            ->add('internalLocation', EntityType::class, [
                'class' => InternalLocation::class,
                'label' => 'Emplacements internes',
                'choice_label' => fn(InternalLocation $loc) => $loc->getLabel(),
                'placeholder' => '',
                'required' => false,
                'attr' => [
                    'data-depend-on' => "Oeuvre_oeuvreStockages_0_type",
                    'data-depend-on-value' => '0',
                ],
            ])
            ->add('description', TextareaType::class)
            ->add('commentaire', TextareaType::class);
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