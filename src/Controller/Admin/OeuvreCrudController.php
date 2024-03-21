<?php

namespace App\Controller\Admin;

use App\Entity\Oeuvre;
use App\Form\Type\BibliographieColectionType;
use App\Form\Type\HistoryCollectionType;
use App\Form\Type\ExpositionCollectionType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Ranky\MediaBundle\Presentation\Form\EasyAdmin\EARankyMediaFileManagerField;

use Doctrine\ORM\EntityManagerInterface;

class OeuvreCrudController extends AbstractCrudController
{
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
            TextField::new('sousTitre'),
            TextareaField::new('serie', 'Série')->stripTags(),
            DateField::new('date'),
            TextField::new('dateComplement', 'Complément de date'),
            TextField::new('dimensions'),
            TextareaField::new('description')->stripTags(),
            FormField::addColumn('col-lg-6'),
            TextareaField::new('commentairePublic', 'Commentaire public')->stripTags(),
            TextareaField::new('commentaireInterne', 'Commentaire interne')->stripTags(),
            AssociationField::new('categorie', 'Catégorie'),
            IntegerField::new('sousCategorie', 'Sous catégorie'),
            TextareaField::new('details', 'Details')->stripTags()->onlyOnDetail(),

            FormField::addTab('Historique'),
            CollectionField::new('oeuvreHistoriques')
                ->setEntryType(HistoryCollectionType::class)
                ->allowAdd()
                ->allowDelete()
                ->renderExpanded(),

            FormField::addTab('Bibliographie'),
            CollectionField::new('oeuvreBibliographies')
                ->setEntryType(BibliographieColectionType::class)
                ->allowAdd()
                ->allowDelete()
                ->renderExpanded(),

            FormField::addTab('Exposition'),
            FormField::addColumn('col-lg-7'),
            CollectionField::new('oeuvreExpositions')
                ->setEntryType(ExpositionCollectionType::class)
                ->allowAdd()
                ->allowDelete()
                ->renderExpanded(),

            FormField::addTab('Localisation'),
            FormField::addTab('Médias'),
            EARankyMediaFileManagerField::new('media')
                ->multipleSelection()
                ->savePath(true)
                ->modalTitle('Galerie'),
        ];
    }
}
