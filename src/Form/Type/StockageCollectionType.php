<?php

namespace App\Form\Type;

use App\Entity\Lieu;
use App\Entity\OeuvreStockage;
use App\Utils\DateChoices;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockageCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day', ChoiceType::class, [
                'choices' => DateChoices::getDayChoices(),
                'label' => 'Jour'
            ])
            ->add('month', ChoiceType::class, [
                'choices' => DateChoices::getMonthChoices(),
                'label' => 'Mois'
            ])
            ->add('year', IntegerType::class, [
                'label' => 'Année'
            ])
            ->add('type', ChoiceType::class, [
                'choices' => DateChoices::getLocalisationTypes()
            ])
            ->add('precisions', ChoiceType::class, [
                'choices' => DateChoices::getLocalisationDetails()
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom'
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