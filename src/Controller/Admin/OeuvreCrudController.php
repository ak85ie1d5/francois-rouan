<?php

namespace App\Controller\Admin;

use App\Entity\Oeuvre;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Ranky\MediaBundle\Presentation\Form\EasyAdmin\EARankyMediaFileManagerField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class OeuvreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Oeuvre::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('numInventaire', 'N°inv'),
            TextField::new('titre'),
            DateField::new('date'),
            TextField::new('dateComplement'),
            TextEditorField::new('description'),
            AssociationField::new('categorie'),
            EARankyMediaFileManagerField::new('media')
                ->multipleSelection()
                ->savePath(true)
                ->modalTitle('Galerie')
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ...
            ->showEntityActionsInlined()
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        $viewProductInPDFFormat = Action::new('viewPDF', 'Imprimer', 'fa fa-file-pdf-o')
            ->linkToRoute('name_of_route_that_generate_pdf_on_one_product',
                function (Oeuvre $oeuvre): array {
                    return [
                        'id' => $oeuvre->getId(),
                    ];
                });

        return $actions
            // add actions in the page index view
            ->add(Crud::PAGE_INDEX, $viewProductInPDFFormat)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)

            // add actions in the page detail view
            ->add(Crud::PAGE_DETAIL, $viewProductInPDFFormat)

            // add actions in the page edit view
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)
            ;
    }

}
