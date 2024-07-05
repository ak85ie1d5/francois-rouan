<?php

namespace App\Controller\Admin;

use App\Entity\OeuvreExposition;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OeuvreExpositionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OeuvreExposition::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->setEntityLabelInSingular('exposition d\'oeuvre')
            ->setEntityLabelInPlural('expositions d\'oeuvres')
            ->setPageTitle('new', 'Créer une %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier l\'%entity_label_singular%');

        return parent::configureCrud($crud);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-lg-5'),
            IdField::new('id')->hideOnForm(),
            TextareaField::new('titre'),

            FormField::addFieldset('Date de début'),
            IntegerField::new('FirstDay', 'Jour')
                ->setColumns(4),
            IntegerField::new('FirstMonth', 'Mois')
                ->setColumns(4),
            IntegerField::new('FirstYear', 'Année')
                ->setColumns(4),

            FormField::addFieldset('Date de fin'),
            IntegerField::new('SecondDay', 'Jour')
                ->hideOnIndex()
                ->setColumns(4),
            IntegerField::new('SecondMonth', 'Mois')
                ->hideOnIndex()
                ->setColumns(4),
            IntegerField::new('SecondYear', 'Année')
                ->hideOnIndex()
                ->setColumns(4),

            FormField::addFieldset(''),
            AssociationField::new('oeuvre')->setCrudController(OeuvreCrudController::class),
            AssociationField::new('lieu')->setCrudController(LieuCrudController::class),


            FormField::addColumn('col-lg-5'),
            TextareaField::new('description'),
            TextareaField::new('commentaire'),

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
