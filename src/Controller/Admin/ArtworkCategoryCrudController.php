<?php

namespace App\Controller\Admin;

use App\Entity\ArtworkCategory;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Umanit\EasyAdminTreeBundle\Controller\TreeCrudController;
use Umanit\EasyAdminTreeBundle\Field\TreeField;


class ArtworkCategoryCrudController extends TreeCrudController
{
    public static function getEntityFqcn(): string
    {
        return ArtworkCategory::class;
    }

    protected function getEntityLabelProperty(): string
    {
        // return the property of your category to use as a label in tree display
        return 'name';
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            AssociationField::new('parent')
        ];
    }

}
