<?php

namespace App\Controller\Admin;

use Adeliom\EasyFieldsBundle\Admin\Field\AssociationField;
use App\Entity\OeuvreExposition;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OeuvreExpositionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OeuvreExposition::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-lg-6'),
            IdField::new('id')->hideOnForm(),
            TextField::new('titre'),
            TextareaField::new('description'),
            TextareaField::new('commentaire'),
            DateField::new('dateDebut'),
            DateField::new('dateFin'),
            DateField::new('dateCreation')->setDisabled()->hideWhenCreating(),
            DateField::new('dateModification')->setDisabled()->hideWhenCreating(),

            FormField::addColumn('col-lg-6'),
            AssociationField::new('oeuvre'),
            AssociationField::new('lieu')
        ];
    }

}
