<?php
namespace App\Admin\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Vich\UploaderBundle\Form\Type\VichImageType;

class VichImageField implements FieldInterface
{
    use FieldTrait;

    /**
     * @param string $propertyName
     * @param string|null $label
     * @return VichImageField|FieldInterface
     */
    public static function new(string $propertyName, ?string $label = null): VichImageField|FieldInterface
    {
        return (new self())
            ->setProperty($propertyName)
            //->setTemplatePath('admin/vich_image.html.twig')
            ->setTemplateName('crud/field/image')
            ->setLabel($label)
            ->setFormType(VichImageType::class)
            ->setFormTypeOptions(['delete_label' => 'Delete image ?'])
            ->addCssClass('field-vich-image');
    }
}