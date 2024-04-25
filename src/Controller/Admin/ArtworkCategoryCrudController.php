<?php

namespace App\Controller\Admin;

use App\Entity\ArtworkCategory;
use App\Entity\OeuvreMediaTest;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Umanit\EasyAdminTreeBundle\Controller\TreeCrudController;
use Umanit\EasyAdminTreeBundle\Field\TreeField;


class ArtworkCategoryCrudController extends TreeCrudController
{
    public static function getEntityFqcn(): string
    {
        return ArtworkCategory::class;
    }

    protected function getEntityLabelProperty(): string
    {
        // return the property of your category to use as a label in tree display
        return 'name';
    }

    public function createEntity(string $entityFqcn)
    {
        $artworkCategory = new ArtworkCategory();
        $artworkCategory->setCreatedBy($this->getUser());

        return $artworkCategory;
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
            TextField::new('name'),
            AssociationField::new('parent'),

            FormField::addColumn('col-lg-5'),
            FormField::addColumn('col-lg-2'),
            DateTimeField::new('createdAt')
                ->setDisabled()
                ->onlyOnForms(),
            DateTimeField::new('updatedAt')
                ->setDisabled()
                ->onlyOnForms(),
            AssociationField::new('createdBy')
                ->setDisabled()
                ->onlyOnForms(),
            AssociationField::new('updatedBy')
                ->setDisabled()
                ->onlyOnForms(),
        ];
    }

}
