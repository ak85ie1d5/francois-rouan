<?php

namespace App\Form\Type;

use App\Entity\Lieu;
use App\Entity\OeuvreStockage;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('nom', TextType::class, [
                'required' => true,
                'row_attr' => [
                    'class' => 'field-text form-group',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            ->add('adresse', TextType::class, [
                'required' => false,
                'row_attr' => [
                    'class' => 'field-text form-group',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            ->add('ville', TextType::class, [
                'required' => false,
                'row_attr' => [
                    'class' => 'field-text form-group',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            ->add('codePostal', TextType::class, [
                'required' => false,
                'row_attr' => [
                    'class' => 'field-text form-group',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            ->add('pays', CountryType::class, [
                'required' => false,
                'row_attr' => [
                    'class' => 'field-country form-group',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'row_attr' => [
                    'class' => 'field-email form-group',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            ->add('tel1', TelType::class, [
                'required' => false,
                'row_attr' => [
                    'class' => 'field-telephone form-group',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            ->add('tel2', TelType::class, [
                'required' => false,
                'row_attr' => [
                    'class' => 'field-telephone form-group',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            ->add('tel3', TelType::class, [
                'required' => false,
                'row_attr' => [
                    'class' => 'field-telephone form-group',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'rows' => 5,
                ],
                'row_attr' => [
                    'class' => 'field-textarea form-group',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            ->add('commentaire', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'rows' => 5,
                ],
                'row_attr' => [
                    'class' => 'field-textarea form-group',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Sauvegarder et quitter'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class
        ]);
    }
}