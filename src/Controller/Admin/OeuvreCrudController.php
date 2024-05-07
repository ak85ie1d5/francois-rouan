<?php

namespace App\Controller\Admin;

use App\Admin\Field\TableField;
use App\Entity\Oeuvre;
use App\Form\Type\BibliographieColectionType;
use App\Form\Type\ExpositionCollectionType;
use App\Form\Type\HistoryCollectionType;
use App\Form\Type\OeuvreMediaTestType;
use App\Form\Type\PrimaryMediaType;
use App\Form\Type\StockageCollectionType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Umanit\EasyAdminTreeBundle\Field\TreeField;


class OeuvreCrudController extends AbstractCrudController
{
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('oeuvre')
            ->setEntityLabelInPlural('oeuvres');
    }

    public static function getEntityFqcn(): string
    {
        return Oeuvre::class;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::persistEntity($entityManager, $entityInstance);


        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('numInventaire')
            ->add('titre')
            ->add('sousTitre')
            ->add('dimensions')
            ->add('date')
            ->add('serie')
            ->add('description')
            ->add('commentairePublic')
            ->add('ArtworkCategory')
            ->add(EntityFilter::new('mediaTest'));
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            FormField::addTab('Général'),
            FormField::addColumn('col-lg-4'),
            TextField::new('numInventaire', 'N°inventaire'),
            TextField::new('titre'),
            TextField::new('sousTitre')
                ->stripTags()
                ->hideOnIndex(),
            TextField::new('serie', 'Série')
                ->stripTags()
                ->hideOnIndex(),
            DateField::new('date'),
            TextField::new('dateComplement', 'Complément de date'),
            TextField::new('dimensions')
                ->hideOnIndex(),

            FormField::addColumn('col-lg-4'),
            TextareaField::new('description')
                ->stripTags(),
            TextareaField::new('commentairePublic', 'Commentaire public')
                ->stripTags()
                ->hideOnIndex(),
            TextareaField::new('commentaireInterne', 'Commentaire interne')
                ->stripTags()
                ->hideOnIndex(),

            TextareaField::new('details', 'Details')
                ->stripTags()
                ->onlyOnDetail(),
            FormField::addColumn('col-lg-3'),
            CollectionField::new('primary_media', 'Image principale')
                ->setEntryType(PrimaryMediaType::class)
                ->addCssClass('primary-media')
                ->addCssFiles('/build/primary-media.css')
                ->hideOnIndex()
                ->allowAdd(false)
                ->allowDelete(false)
                ->renderExpanded(),
            TreeField::new('ArtworkCategory', 'Catégorie')
                ->hideOnIndex(),
            FormField::addTab('Historique'),
            CollectionField::new('oeuvreHistoriques', 'Historique de l\'oeuvre')
                ->setEntryType(HistoryCollectionType::class)
                ->allowAdd()
                ->allowDelete()
                ->renderExpanded()
                ->hideOnIndex(),
            FormField::addTab('Bibliographie'),
            CollectionField::new('oeuvreBibliographies', 'Bibliographie de l\'oeuvre')
                ->setEntryType(BibliographieColectionType::class)
                ->allowAdd()
                ->allowDelete()
                ->renderExpanded()
                ->hideOnIndex(),
            FormField::addTab('Exposition'),
            FormField::addColumn('col-lg-7'),
            CollectionField::new('oeuvreExpositions', 'Exposition de l\'oeuvre')
                ->setEntryType(ExpositionCollectionType::class)
                ->allowAdd()
                ->allowDelete()
                ->renderExpanded()
                ->hideOnIndex(),
            FormField::addTab('Localisation'),
            TableField::new('oeuvreStockages', 'Dernière localisation ')
                ->setEntryType(StockageCollectionType::class)
                ->allowAdd()
                ->allowDelete()
                ->setEntryIsComplex()
                ,
            FormField::addTab('Médias'),
            TableField::new('mediaTest', 'Image principale')
                ->setEntryType(OeuvreMediaTestType::class)
                ->setTemplatePath('admin/vich_image_collection.html.twig')
                ->allowAdd()
                ->allowDelete()
                ->setEntryIsComplex(),
        ];
    }
}
