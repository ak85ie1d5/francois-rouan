<?php

namespace App\Controller\Admin;

use App\Entity\OeuvreHistorique;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OeuvreHistoriqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OeuvreHistorique::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('titre'),
            DateField::new('date'),
            TextareaField::new('description'),
            TextareaField::new('commentaire'),
            DateField::new('dateCreation')->setDisabled()->hideWhenCreating(),
            DateField::new('dateModification')->setDisabled()->hideWhenCreating(),
            AssociationField::new('oeuvre')
        ];
    }

}
