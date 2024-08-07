<?php

namespace App\Form\Type;

use App\Entity\ArtworkMedia;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyPath;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArtworkMediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'allow_delete' => false,
                'label' => 'Image'
            ])
            ->add('libelle', TextType::class, [
                'label' => 'Nom de fichier',
            ])
            ->add('caption', TextareaType::class, [
                'label' => 'Légende',
                'attr' => [
                    'rows' => 5
                ],
            ])
            ->add('position', HiddenType::class, [
                'empty_data' => 1,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArtworkMedia::class,
        ]);
    }


    public function getBlockPrefix(): string
    {
        return 'artwork_media';
    }
}
