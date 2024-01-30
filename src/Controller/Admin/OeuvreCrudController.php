<?php

namespace App\Controller\Admin;

use Adeliom\EasyMediaBundle\Admin\Field\EasyMediaField;
use App\Entity\Oeuvre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OeuvreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Oeuvre::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $userID = 1;
        return [
            IdField::new('id'),
            TextField::new('titre'),
            TextEditorField::new('description'),
            EasyMediaField::new('media', "label")
                // Apply restrictions by mime-types
                ->setFormTypeOption("restrictions_uploadTypes", ["image/*"])
                // Apply restrictions to upload size in MB
                ->setFormTypeOption("restrictions_uploadSize", null)
                // Apply restrictions to path
                ->setFormTypeOption("restrictions_path", "users/" . $userID)
                // Hide fiels with extensions (null or array)
                ->setFormTypeOption("hideExt", ["svg"])
                // Hide folders (null or array)
                ->setFormTypeOption("hidePath", ['others', 'users/testing'])
                // Enable/Disable actions
                ->setFormTypeOption("editor", true)
                ->setFormTypeOption("upload", true)
                ->setFormTypeOption("bulk_selection", true)
                ->setFormTypeOption("move", true)
                ->setFormTypeOption("rename", true)
                ->setFormTypeOption("metas", true)
                ->setFormTypeOption("delete", true)
        ];
    }

}
