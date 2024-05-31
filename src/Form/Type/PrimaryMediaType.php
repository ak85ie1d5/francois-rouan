<?php

namespace App\Form\Type;

use App\Entity\ArtworkMedia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PrimaryMediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'allow_delete' => false,
                'allow_file_upload' => false,
                'label' => ''
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArtworkMedia::class,
        ]);
    }


    public function getBlockPrefix(): string
    {
        return 'artwork_media_primary';
    }
}