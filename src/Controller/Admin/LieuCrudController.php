<?php

namespace App\Controller\Admin;

use App\Entity\Lieu;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LieuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Lieu::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $artworkCategory = new Lieu();
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
        return $crud
            ->setEntityLabelInSingular('lieu')
            ->setEntityLabelInPlural('lieux')
            ->setPageTitle('edit', 'Modifier le %entity_label_singular%');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Général'),
            FormField::addColumn('col-lg-5'),
            TextField::new('nom'),
            TextField::new('adresse'),
            TextField::new('ville'),
            TextField::new('codePostal'),
            CountryField::new('pays')
                ->hideOnIndex(),
            EmailField::new('email')
                ->hideOnIndex(),

            FormField::addColumn('col-lg-5'),
            TelephoneField::new('tel1')
                ->hideOnIndex(),
            TelephoneField::new('tel2')
                ->hideOnIndex(),
            TelephoneField::new('tel3')
                ->hideOnIndex(),
            TextareaField::new('description')
                ->hideOnIndex(),
            TextareaField::new('commentaire')
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

            FormField::addTab('Expositions'),
            CollectionField::new('oeuvreExpositions')
                ->hideOnIndex(),

            FormField::addTab('Localisations'),
            CollectionField::new('oeuvreStockages')
                ->hideOnIndex(),
        ];
    }
}
