<?php

namespace App\Controller\Admin;

use App\Entity\OeuvreHistorique;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OeuvreHistoriqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OeuvreHistorique::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->setEntityLabelInSingular('historique d\'oeuvre')
            ->setEntityLabelInPlural('historiques d\'oeuvres')
            ->setPageTitle('edit', 'Modifier l\'%entity_label_singular%');

        return parent::configureCrud($crud);
    }

    public function createEntity(string $entityFqcn)
    {
        $artworkCategory = new OeuvreHistorique();
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
            TextField::new('titre'),
            DateField::new('date'),
            TextareaField::new('description'),
            TextareaField::new('commentaire'),
            FormField::addColumn('col-lg-5'),
            AssociationField::new('oeuvre'),
            FormField::addColumn('col-lg-2'),
            DateField::new('createdAt')->setDisabled()->hideWhenCreating(),
            DateField::new('updatedAt')->setDisabled()->hideWhenCreating(),
            AssociationField::new('createdBy')
                ->setDisabled()
                ->onlyOnForms(),
            AssociationField::new('updatedBy')
                ->setDisabled()
                ->onlyOnForms(),
        ];
    }

}
