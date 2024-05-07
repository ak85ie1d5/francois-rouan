<?php

namespace App\Controller\Admin;

use App\Entity\OeuvreBibliographie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OeuvreBibliographieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OeuvreBibliographie::class;
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
            IdField::new('id')->hideOnForm(),
            TextField::new('titre'),
            TextareaField::new('description'),
            TextareaField::new('commentaire'),
            DateTimeField::new('date'),

            FormField::addColumn('col-lg-5'),
            AssociationField::new('oeuvre')
                ->setCrudController(OeuvreCrudController::class),

            FormField::addColumn('col-lg-2'),
            DateTimeField::new('dateCreation')->setDisabled()->hideWhenCreating(),
            DateTimeField::new('dateModification')->setDisabled()->hideWhenCreating(),
            //ArrayField::new('createur')->setDisabled()->hideWhenCreating(),
            //ArrayField::new('modificateur')->setDisabled()->hideWhenCreating(),

        ];
    }
}
