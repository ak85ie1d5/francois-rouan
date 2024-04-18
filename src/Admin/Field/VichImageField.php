<?php
namespace App\Admin\Field;

use App\Form\Type\OeuvreMediaTestType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Vich\UploaderBundle\Form\Type\VichImageType;

class VichImageField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null)
    {
        return (new self())
            ->setProperty($propertyName)
            ->setTemplatePath('admin/vich_image.html.twig')
            ->setLabel($label)
            ->setFormType(VichImageType::class)
            ->addCssClass('field-vich-image');
    }
}