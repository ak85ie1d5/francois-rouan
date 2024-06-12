<?php

namespace App\Form\Type;

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

    public function buildForm(FormBuilderInterface $builder, array $options)
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
                'label' => 'Année'
            ])
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
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nom', 'ASC');
                },
                'choice_label' => 'nom',
                'placeholder' => '',
            ])
            ->add('description', TextareaType::class)
            ->add('commentaire', TextareaType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OeuvreStockage::class
        ]);
    }
}