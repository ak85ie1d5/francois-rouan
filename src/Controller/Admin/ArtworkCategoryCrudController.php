<?php

namespace App\Controller\Admin;

use App\Entity\ArtworkCategory;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Umanit\EasyAdminTreeBundle\Controller\TreeCrudController;


class ArtworkCategoryCrudController extends TreeCrudController
{
    public static function getEntityFqcn(): string
    {
        return ArtworkCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->setEntityLabelInSingular('Catégorie d\'oeuvres')
            ->setEntityLabelInPlural('Catégories d\'oeuvres');

        return parent::configureCrud($crud);
    }

    /**
     * Return the property of the category to use as a label in tree display
     *
     * @return string
     */
    protected function getEntityLabelProperty(): string
    {

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
            TextField::new('name', 'Nom de la catégorie'),
            AssociationField::new('parent', 'Catégorie parente'),

            FormField::addColumn('col-lg-5'),
            FormField::addColumn('col-lg-2'),
            DateTimeField::new('createdAt', 'Date de creation')
                ->setDisabled()
                ->onlyOnForms(),
            DateTimeField::new('updatedAt', 'Date de modification')
                ->setDisabled()
                ->onlyOnForms(),
            AssociationField::new('createdBy', 'Créé par')
                ->setDisabled()
                ->onlyOnForms(),
            AssociationField::new('updatedBy', 'Modifier par')
                ->setDisabled()
                ->onlyOnForms(),
        ];
    }

}
