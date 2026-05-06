<?php

namespace App\Admin\Field;

use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use App\Form\TreeFieldType;

class TreeField implements FieldInterface
{
    use FieldTrait;

    public const OPTION_CLASS = 'class';

    /**
     * @param string $propertyName
     * @param string|null $label
     * @return TreeField|FieldInterface
     */
    public static function new(string $propertyName, ?string $label = null): FieldInterface|TreeField
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->addFormTheme('bundles/UmanitEasyAdminTreeBundle/crud/field/form_theme.html.twig')
            ->setFormType(TreeFieldType::class)
            ->addCssFiles(Asset::new('styles/tree-field.css'))
            ->addJsFiles(Asset::new('umanit-easyadmintree-tree-field.js'))
            ;
    }
}
