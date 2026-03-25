<?php

namespace App\Controller\Admin;

use App\Entity\InternalLocation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class InternalLocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InternalLocation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->setEntityLabelInSingular('emplacement interne')
            ->setEntityLabelInPlural('emplacements internes')
            ->setPageTitle('new', 'Créer un %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier l\'%entity_label_singular%')
            ->overrideTemplate('crud/index', 'bundles/UmanitEasyAdminTreeBundle/crud/field/index.html.twig')
            ->setPaginatorPageSize(9999999)
            ->showEntityActionsInlined()
            ->setDefaultSort(['root' => 'ASC', 'lft' => 'ASC'])
            ->setSearchFields(null);

        return parent::configureCrud($crud);
    }

    public function configureAssets(Assets $assets): Assets
    {
        $assets = parent::configureAssets($assets);
        return $assets
            ->addCssFile('styles/tree.css');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('label', 'Emplacement')
                ->onlyOnIndex()
                ->setMaxLength(100),
            FormField::addColumn('col-lg-5'),
            AssociationField::new('parent', 'Parent'),
            TextField::new('RoomCode', 'Code'),
            TextField::new('RoomLabel', 'Libellé'),

            FormField::addColumn('col-lg-5'),

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

    public function configureActions(Actions $actions): Actions
    {
        $actions
            ->update(Crud::PAGE_INDEX, Action::EDIT,
                function (Action $action) {
                    return $action
                        ->asTextLink()
                        ->asPrimaryAction();
                });
        return parent::configureActions($actions);
    }
}
