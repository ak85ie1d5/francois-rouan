<?php

namespace App\Controller\Admin;

use App\Entity\ArtworkCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class ArtworkCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ArtworkCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->setEntityLabelInSingular('catégorie d\'oeuvres')
            ->setEntityLabelInPlural('catégories d\'oeuvres')
            ->setPageTitle('new', 'Créer une %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier la %entity_label_singular%')
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
            FormField::addColumn('col-lg-5'),
            TextField::new('name', 'Nom de la catégorie'),
            AssociationField::new('parent', 'Catégorie parente'),

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
