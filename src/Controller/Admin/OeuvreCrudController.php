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
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Umanit\EasyAdminTreeBundle\Field\TreeField;
use Vich\UploaderBundle\Storage\StorageInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;


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

    private $storage;

    /**
     * Inject the StorageInterface instance into the controller.
     *
     * OeuvreCrudController constructor.
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Override the createEntity method to provide the necessary StorageInterface instance.
     *
     * @param string $entityFqcn
     * @return Oeuvre|mixed
     */
    public function createEntity(string $entityFqcn): mixed
    {
        if ($entityFqcn === Oeuvre::class) {
            $oeuvre = new Oeuvre($this->storage);
            $oeuvre->setCreatedBy($this->getUser());

            return $oeuvre;
        }

        return parent::createEntity($entityFqcn);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setUpdatedBy($this->getUser());

        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::persistEntity($entityManager, $entityInstance);


        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    /**
     * Configure the actions for the OeuvreCrudController.
     *
     * @param Actions $actions
     * @return Actions
     */
    public function configureActions(Actions $actions): Actions
    {
        // Create a new action to generate a PDF of the Oeuvre entity.
        $pdf = Action::new('pdf', 'PDF', 'fa fa-file-pdf')
            ->linkToRoute('pdf_oeuvre', function (Oeuvre $entity) {
                return ['id' => $entity->getId()];
            })
            ->setHtmlAttributes([
                'target' => '_blank',
            ]);

        $actions
            ->add(Crud::PAGE_INDEX, $pdf);

        return parent::configureActions($actions);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('numInventaire')
            ->add('titre')
            ->add('sousTitre')
            ->add('dimensions')
            ->add('FirstDay')
            ->add('FirstMonth')
            ->add('FirstYear')
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
            TextField::new('numInventaire', 'N°inv'),
            TextField::new('titre'),
            TextField::new('sousTitre')
                ->stripTags()
                ->hideOnIndex(),
            TextField::new('serie', 'Série')
                ->stripTags()
                ->hideOnIndex(),
            FormField::addFieldset('Date de création'),
            IntegerField::new('FirstDay', 'Jour')
                ->setColumns(4),
            IntegerField::new('FirstMonth', 'Mois')
                ->setColumns(4),
            IntegerField::new('FirstYear', 'Année')
                ->setColumns(4),
            BooleanField::new('FirstDateUncertain', 'Date incertaine')
                ->hideOnIndex(),
            IntegerField::new('SecondDay', 'Jour')
                ->hideOnIndex()
                ->setColumns(4),
            IntegerField::new('SecondMonth', 'Mois')
                ->hideOnIndex()
                ->setColumns(4),
            IntegerField::new('SecondYear', 'Année')
                ->hideOnIndex()
                ->setColumns(4),
            BooleanField::new('SecondDateUncertain', 'Date incertaine')
                ->hideOnIndex(),


            FormField::addColumn('col-lg-4'),
            TextField::new('dimensions')
                ->hideOnIndex(),
            TextareaField::new('description')
                ->stripTags(),
            TextareaField::new('commentairePublic', 'Commentaire public')
                ->stripTags()
                ->hideOnIndex(),
            TextareaField::new('commentaireInterne', 'Commentaire interne')
                ->stripTags()
                ->hideOnIndex(),
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
            TableField::new('oeuvreBibliographies', 'Bibliographie de l\'oeuvre')
                ->setEntryType(BibliographieColectionType::class)
                ->allowAdd()
                ->allowDelete()
                ->setEntryIsComplex()
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
                ->setEntryIsComplex(),
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
