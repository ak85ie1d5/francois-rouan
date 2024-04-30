<?php

namespace App\Form\Type;

use App\Entity\OeuvreMediaTest;
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
            'data_class' => OeuvreMediaTest::class,
        ]);
    }


    public function getBlockPrefix(): string
    {
        return 'media_test';
    }
}