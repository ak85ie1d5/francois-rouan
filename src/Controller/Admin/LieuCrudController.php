<?php

namespace App\Controller\Admin;

use App\Entity\Lieu;
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
