<?php

namespace App\Controller\Admin;

use App\Admin\Field\TableField;
use App\Entity\Oeuvre;
use App\Form\Type\BibliographieColectionType;
use App\Form\Type\ExpositionCollectionType;
use App\Form\Type\HistoryCollectionType;
use App\Form\Type\StockageCollectionType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Ranky\MediaBundle\Presentation\Form\EasyAdmin\EARankyMediaFileManagerField;

class OeuvreCrudController extends AbstractCrudController
{
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ...

            // don't forget to add EasyAdmin's form theme at the end of the list
            // (otherwise you'll lose all the styles for the rest of form fields)
            ->setFormThemes(['admin/table.html.twig', '@EasyAdmin/crud/form_theme.html.twig'])
            ;
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

    public function configureFields(string $pageName): iterable
    {

        return [
            FormField::addTab('Général'),
            FormField::addColumn('col-lg-6'),
            TextField::new('numInventaire', 'N°inv'),
            TextField::new('titre'),
            TextField::new('sousTitre')
                ->stripTags()
                ->hideOnIndex(),
            TextareaField::new('serie', 'Série')
                ->stripTags()
                ->hideOnIndex(),
            DateField::new('date'),
            TextField::new('dateComplement', 'Complément de date'),
            TextField::new('dimensions')
                ->hideOnIndex(),
            TextareaField::new('description')
                ->stripTags(),
            FormField::addColumn('col-lg-6'),
            TextareaField::new('commentairePublic', 'Commentaire public')
                ->stripTags()
                ->hideOnIndex(),
            TextareaField::new('commentaireInterne', 'Commentaire interne')
                ->stripTags()
                ->hideOnIndex(),
            AssociationField::new('categorie', 'Catégorie')
                ->hideOnIndex(),
            IntegerField::new('sousCategorie', 'Sous catégorie')
                ->hideOnIndex(),
            TextareaField::new('details', 'Details')
                ->stripTags()
                ->onlyOnDetail(),
            FormField::addTab('Historique'),
            CollectionField::new('oeuvreHistoriques')
                ->setEntryType(HistoryCollectionType::class)
                ->allowAdd()
                ->allowDelete()
                ->renderExpanded()
                ->hideOnIndex(),
            FormField::addTab('Bibliographie'),
            CollectionField::new('oeuvreBibliographies')
                ->setEntryType(BibliographieColectionType::class)
                ->allowAdd()
                ->allowDelete()
                ->renderExpanded()
                ->hideOnIndex(),
            FormField::addTab('Exposition'),
            FormField::addColumn('col-lg-7'),
            CollectionField::new('oeuvreExpositions')
                ->setEntryType(ExpositionCollectionType::class)
                ->allowAdd()
                ->allowDelete()
                ->renderExpanded()
                ->hideOnIndex(),
            FormField::addTab('Localisation'),
            TableField::new('oeuvreStockages')
                ->setEntryType(StockageCollectionType::class)
                ->allowAdd()
                ->allowDelete(false)
                ->hideOnIndex(),
            FormField::addTab('Médias'),
            EARankyMediaFileManagerField::new('medias')
                ->association()
                ->multipleSelection()
                ->modalTitle('Galerie'),
            /*FormField::addTab('Média (JSON)'),
            EARankyMediaFileManagerField::new('media')
                ->multipleSelection()
                ->savePath(true)
                ->modalTitle('Galerie'),*/
        ];
    }
}
