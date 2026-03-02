<?php

namespace App\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TreeFieldType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'expanded'      => true,
            'block_name'    => 'umanit_easyadmin_tree',
            'query_builder' => function (EntityRepository $er) {
                return $er
                    ->createQueryBuilder('entity')
                    ->orderBy('entity.root, entity.lft', 'ASC')
                    ;
            },
            'choice_attr'   => function ($choice, $key, $value) {
                return ['data-level' => $choice->getLvl(), 'data-has-child' => !$choice->getChildren()->isEmpty()];
            },
            'placeholder' => 'Aucun',
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
