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
            IdField::new('id')->hideOnForm(),

            TextField::new('nom'),
            TextField::new('organisme'),
            TextField::new('adresse'),
            TextField::new('ville'),
            TextField::new('codePostal'),
            CountryField::new('pays'),
            EmailField::new('email'),

            FormField::addColumn('col-lg-5'),
            TelephoneField::new('tel1'),
            TelephoneField::new('tel2'),
            TelephoneField::new('tel3'),
            TextareaField::new('description'),
            TextareaField::new('commentaire'),

            FormField::addColumn('col-lg-2'),
            DateTimeField::new('dateCreation')->setDisabled()->hideWhenCreating(),
            DateTimeField::new('dateModification')->setDisabled()->hideWhenCreating(),
            //ArrayField::new('createur')->setDisabled()->hideWhenCreating(),
            //ArrayField::new('modificateur')->setDisabled()->hideWhenCreating(),

            FormField::addTab('Expositions'),
            CollectionField::new('oeuvreExpositions'),

            FormField::addTab('Localisations'),
            CollectionField::new('oeuvreStockages'),
        ];
    }

}
