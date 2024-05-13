<?php

namespace App\Controller\Admin;

use App\Entity\OeuvreBibliographie;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OeuvreBibliographieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OeuvreBibliographie::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $artworkCategory = new OeuvreBibliographie();
        $artworkCategory->setCreatedBy($this->getUser());

        return $artworkCategory;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setUpdatedBy($this->getUser());

        parent::updateEntity($entityManager, $entityInstance);
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->setEntityLabelInSingular('bibliographie d\'oeuvre')
            ->setEntityLabelInPlural('bibliographies d\'oeuvres')
            ->setPageTitle('new', 'Créer une %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier la %entity_label_singular%');

        return parent::configureCrud($crud);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-lg-5'),
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('titre'),
            IntegerField::new('Year')
                ->setLabel('Année')
                ->setColumns('col-lg-2'),
            AssociationField::new('oeuvre')
                ->setCrudController(OeuvreCrudController::class),
            FormField::addColumn('col-lg-5'),
            TextareaField::new('description'),
            TextareaField::new('commentaire'),
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
