<?php

namespace App\Form\Type;

use App\Entity\Lieu;
use App\Entity\OeuvreStockage;
use App\Utils\DateChoices;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockageCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class)
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
            ->add('dateDebut', DateType::class)
            ->add('dateFin', DateType::class)
            ->add('description', TextareaType::class)
            ->add('commentaire', TextareaType::class)
            ->add('precisions', TextType::class)
            ->add('type', TextType::class)
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OeuvreStockage::class
        ]);
    }
}