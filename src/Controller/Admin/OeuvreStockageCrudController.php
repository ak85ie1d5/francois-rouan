<?php

namespace App\Controller\Admin;

use App\Entity\OeuvreStockage;
use App\Service\Options;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class OeuvreStockageCrudController extends AbstractCrudController
{
    private Options $options;

    public function __construct(Options $options)
    {
        $this->options = $options;
    }

    public static function getEntityFqcn(): string
    {
        return OeuvreStockage::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->setEntityLabelInSingular('localisation d\'oeuvres')
            ->setEntityLabelInPlural('localisation d\'oeuvres')
            ->setPageTitle('new', 'Créer une %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier la %entity_label_singular%');

        return parent::configureCrud($crud);
    }

    public function createEntity(string $entityFqcn)
    {
        $artworkCategory = new OeuvreStockage();
        $artworkCategory->setCreatedBy($this->getUser());

        return $artworkCategory;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setUpdatedBy($this->getUser());

        parent::updateEntity($entityManager, $entityInstance);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-lg-5'),
            IdField::new('id')->hideOnForm(),
            FormField::addFieldset('Date de début'),
            ChoiceField::new('FirstDay', 'Jour')
                ->setChoices($this->options->getDayNumeric())
                ->setColumns(4),
            ChoiceField::new('FirstMonth', 'Mois')
                ->setChoices($this->options->getMonthTextual())
                ->setColumns(4),
            IntegerField::new('FirstYear', 'Année')
                ->setColumns(4),

            FormField::addFieldset(),
            ChoiceField::new('precisions')
                ->setChoices($this->options->getLocationDetails()),
            ChoiceField::new('type')
                ->setChoices($this->options->getLocationTypes()),
            AssociationField::new('oeuvre'),
            AssociationField::new('lieu'),
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
