<?php

namespace App\Controller\Admin;

use App\Entity\ArtworkMedia;
use App\Service\Options;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ArtworkMediaCrudController extends AbstractCrudController
{

    private Options $options;

    public function __construct(Options $options)
    {
        $this->options = $options;
    }

    public static function getEntityFqcn(): string
    {
        return ArtworkMedia::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->setEntityLabelInSingular('média')
            ->setEntityLabelInPlural('médias')
            ->setPageTitle('edit', 'Modifier le %entity_label_singular%');

        return parent::configureCrud($crud);
    }

    public function configureAssets(Assets $assets): Assets
    {
        $assets = parent::configureAssets($assets);
        return $assets
            ->addJsFile(Asset::new('field-depend-on.js'));
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-lg-5'),
            TextareaField::new('libelle'),
            IntegerField::new('position'),
            TextField::new('nom')
                ->setDisabled()
                ->hideWhenCreating(),
            TextField::new('mime')
                ->setDisabled()
                ->hideWhenCreating(),
            IntegerField::new('taille')
                ->setDisabled()
                ->hideWhenCreating(),
            AssociationField::new('oeuvre')
                ->hideWhenCreating(),
            FormField::addColumn('col-lg-5'),
            ChoiceField::new('photoCredit', 'Crédit photo')
                ->setChoices($this->options->getPhotoCredit()),
            TextField::new('photographerName', 'Nom du photographe')
                ->setFormTypeOption('row_attr', [
                    'data-depend-on' => 'ArtworkMedia_photoCredit',
                    'data-depend-on-value' => '1',
                ]),
            ImageField::new('imageFile', 'Image')
                ->onlyOnIndex(),
            TextareaField::new('imageFile', 'Image')
                ->setFormType(VichImageType::class)
                ->hideOnIndex(),

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
