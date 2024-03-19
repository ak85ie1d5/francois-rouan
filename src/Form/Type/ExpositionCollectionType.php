<?php
namespace App\Form\Type;

use App\Entity\Lieu;
use App\Entity\OeuvreExposition;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('dateDebut', DateType::class)
            ->add('dateFin', DateType::class)
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom'
            ])
            ->add('AjouterUnLieu', CollectionType::class, [
                'entry_type' => LieuCollectionType::class,
                'entry_options' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OeuvreExposition::class
        ]);
    }
}
