<?php

namespace App\Controller\Admin;

use App\Admin\Field\VichImageField;
use App\Entity\OeuvreMediaTest;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;


class OeuvreMediaTestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OeuvreMediaTest::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $oeuvreMediaTest = new OeuvreMediaTest();
        $oeuvreMediaTest->setCreateur($this->getUser());

        return $oeuvreMediaTest;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-lg-5'),
            TextareaField::new('description'),
            IntegerField::new('position'),
            TextField::new('nom')
                ->hideWhenCreating(),
            TextField::new('emplacement')
                ->hideWhenCreating(),
            TextField::new('extension')
                ->hideWhenCreating(),
            TextField::new('mime')
                ->hideWhenCreating(),
            IntegerField::new('taille')
                ->hideWhenCreating(),
            AssociationField::new('oeuvre')
                ->hideWhenCreating(),
            VichImageField::new('imageFile'),
            TextareaField::new('imageFile')
                ->setFormType(VichImageType::class)
                ->hideOnIndex(),
            FormField::addColumn('col-lg-5'),
            FormField::addColumn('col-lg-2'),
            DateTimeField::new('dateCreation')
                ->setDisabled()
                ->onlyOnForms(),
            DateTimeField::new('dateModification')
                ->setDisabled()
                ->onlyOnForms(),
            AssociationField::new('createur')
                ->setDisabled()
                ->onlyOnForms(),
            AssociationField::new('modificateur')
                ->setDisabled()
                ->onlyOnForms(),
        ];
    }
}