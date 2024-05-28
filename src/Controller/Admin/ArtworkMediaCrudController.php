<?php

namespace App\Controller\Admin;

use App\Admin\Field\VichImageField;
use App\Entity\ArtworkMedia;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ArtworkMediaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ArtworkMedia::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->setEntityLabelInSingular('média')
            ->setEntityLabelInPlural('médias')
            ->setPageTitle('edit', 'Modifier le %entity_label_singular%');

        return parent::configureCrud($crud);
    }

    public function createEntity(string $entityFqcn)
    {
        $artworkMedia = new ArtworkMedia();
        $artworkMedia->setCreatedBy($this->getUser());

        return $artworkMedia;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setUpdatedBy($this->getUser());

        parent::updateEntity($entityManager, $entityInstance);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-lg-5'),
            TextareaField::new('description'),
            IntegerField::new('position'),
            TextField::new('nom')
                ->hideWhenCreating(),
            TextField::new('extension')
                ->hideWhenCreating(),
            TextField::new('mime')
                ->hideWhenCreating(),
            IntegerField::new('taille')
                ->hideWhenCreating(),
            AssociationField::new('oeuvre')
                ->hideWhenCreating(),
            FormField::addColumn('col-lg-5'),
            ImageField::new('imageFile', 'Image')
                ->onlyOnIndex(),
            TextareaField::new('imageFile', 'Image')
                ->setFormType(VichImageType::class)
                ->hideOnIndex(),
            FormField::addColumn('col-lg-2'),
            DateField::new('createdAt')
                ->setDisabled()
                ->hideWhenCreating(),
            DateField::new('updatedAt')
                ->setDisabled()
                ->hideWhenCreating(),
            AssociationField::new('createdBy')
                ->setDisabled()
                ->onlyOnForms(),
            AssociationField::new('updatedBy')
                ->setDisabled()
                ->onlyOnForms(),
        ];
    }
}