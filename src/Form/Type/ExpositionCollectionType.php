<?php
namespace App\Form\Type;

use App\Entity\OeuvreExposition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpositionCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Ajoutez ici les champs que vous souhaitez afficher pour chaque élément de la collection OeuvreHistorique
        $builder
            ->add('titre', TextType::class)
            ->add('description', TextareaType::class)
            ->add('commentaire', TextareaType::class)
            ->add('dateDebut', DateTimeType::class)
            ->add('dateFin', DateTimeType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OeuvreExposition::class
        ]);
    }
}
