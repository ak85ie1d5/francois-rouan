<?php

namespace App\Controller\Admin;

use App\Entity\OeuvreCategorie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OeuvreCategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OeuvreCategorie::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            AssociationField::new('sousCategorie')->autocomplete(),
            TextareaField::new('description'),
            TextareaField::new('Commentaire'),
            DateField::new('dateCreation'),
            DateField::new('dateModification')
        ];
    }
}
