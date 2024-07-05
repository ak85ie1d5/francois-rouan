<?php

namespace App\Controller\Admin;

use App\Entity\OeuvreHistorique;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

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

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-lg-5'),
            TextareaField::new('description'),
            FormField::addColumn('col-lg-5'),
            AssociationField::new('oeuvre'),

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
