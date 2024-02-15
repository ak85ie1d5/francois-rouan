<?php

namespace App\Controller\Admin;

use App\Entity\Oeuvre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Ranky\MediaBundle\Presentation\Form\EasyAdmin\EARankyMediaFileManagerField;

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
            EARankyMediaFileManagerField::new('media')
                ->multipleSelection()
                ->savePath(true)
                ->modalTitle('Galerie')
        ];
    }

}
