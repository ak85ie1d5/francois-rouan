<?php

namespace App\Form\Type;

use App\Entity\Lieu;
use App\Entity\OeuvreStockage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockageCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $colWidth = 100/8;

        $builder
            ->add('titre', TextType::class)
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