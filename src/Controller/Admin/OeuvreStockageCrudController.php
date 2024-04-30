<?php

namespace App\Controller\Admin;

use App\Entity\OeuvreStockage;
use App\Utils\DateChoices;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OeuvreStockageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OeuvreStockage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-lg-5'),
            IdField::new('id')->hideOnForm(),
            TextField::new('titre'),

            FormField::addFieldset('Date de début'),
            ChoiceField::new('day', 'Jour')
                ->setChoices(DateChoices::getDayChoices())
                ->setColumns(4),
            ChoiceField::new('month', 'Mois')
                ->setChoices(DateChoices::getMonthChoices())
                ->setColumns(4),
            IntegerField::new('year', 'Année')
                ->setColumns(4),

            FormField::addFieldset(),
            FormField::addRow(),
            DateField::new('dateDebut'),
            DateField::new('dateFin'),
            TextareaField::new('description'),
            TextareaField::new('commentaire'),
            TextField::new('precisions'),
            TextField::new('type'),

            FormField::addColumn('col-lg-5'),
            AssociationField::new('oeuvre'),
            AssociationField::new('lieu'),

            FormField::addColumn('col-lg-2'),
            DateTimeField::new('dateCreation')->setDisabled()->hideWhenCreating(),
            DateTimeField::new('dateModification')->setDisabled()->hideWhenCreating(),
            //ArrayField::new('createur')->setDisabled()->hideWhenCreating(),
            //ArrayField::new('modificateur')->setDisabled()->hideWhenCreating(),

        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('edit', 'Modifier la localisation');
    }
}
