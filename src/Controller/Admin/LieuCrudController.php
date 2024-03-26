<?php

namespace App\Controller\Admin;

use App\Entity\Lieu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LieuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Lieu::class;
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
            DateTimeField::new('dateCreation')
                ->setDisabled()
                ->onlyOnForms(),
            DateTimeField::new('dateModification')
                ->setDisabled()
                ->onlyOnForms(),
            //ArrayField::new('createur')->setDisabled()->hideWhenCreating(),
            //ArrayField::new('modificateur')->setDisabled()->hideWhenCreating(),

            FormField::addTab('Expositions'),
            CollectionField::new('oeuvreExpositions')
                ->hideOnIndex(),

            FormField::addTab('Localisations'),
            CollectionField::new('oeuvreStockages')
                ->hideOnIndex(),
        ];
    }

}
