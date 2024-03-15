<?php

namespace App\Form;

use App\Entity\OeuvreHistorique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class TableRowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class)
            ->add('date', DateType::class)
            ->add('description', TextareaType::class)
            ->add('commentaire', TextareaType::class)
            ->add('dateCreation', DateType::class)
            ->add('dateModification', DateType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OeuvreHistorique::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'collection_row';
    }
}
