<?php

namespace App\Form\Type;

use App\Entity\Lieu;
use App\Entity\OeuvreStockage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('adresse', TextType::class)
            ->add('ville', TextType::class)
            ->add('codePostal', TextType::class)
            ->add('tel1', TelType::class)
            ->add('tel2', TelType::class)
            ->add('tel3', TelType::class)
            ->add('email', EmailType::class)
            ->add('description', TextareaType::class)
            ->add('commentaire', TextareaType::class)
            ->add('organisme', TextType::class)
            ->add('pays', CountryType::class)
            /*->add('oeuvreStockages', EntityType::class, [
                'class' => OeuvreStockage::class,
                'placeholder' => 'Sélectionnez une localisation',
                'choice_label' => 'titre'
            ])*/;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class
        ]);
    }
}