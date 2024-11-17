<?php

namespace App\Controller\Admin;

use App\Admin\Field\TableField;
use App\Controller\Admin\Filter\ArtworkMediaFilter;
use App\Controller\Admin\Filter\BibliographyFilter;
use App\Controller\Admin\Filter\ExhibitionFilter;
use App\Controller\Admin\Filter\HistoryFilter;
use App\Controller\Admin\Filter\LocationFilter;
use App\Entity\Oeuvre;
use App\Form\Type\BibliographieColectionType;
use App\Form\Type\ExpositionCollectionType;
use App\Form\Type\HistoryCollectionType;
use App\Form\Type\ArtworkMediaType;
use App\Form\Type\PrimaryMediaType;
use App\Form\Type\StockageCollectionType;
use App\Repository\OeuvreRepository;
use App\Service\Options;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Routing\Annotation\Route;
use Umanit\EasyAdminTreeBundle\Field\TreeField;
use Vich\UploaderBundle\Storage\StorageInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;


class OeuvreCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;

    private $storage;

    private $options;

    private $oeuvreRepository;

    /**
     * Inject the StorageInterface instance into the controller.
     *
     * OeuvreCrudController constructor.
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage, AdminUrlGenerator $adminUrlGenerator, Options $options, OeuvreRepository $oeuvreRepository)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->storage = $storage;
        $this->options = $options;
        $this->oeuvreRepository = $oeuvreRepository;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('oeuvre')
            ->setEntityLabelInPlural('oeuvres')
            ->setPageTitle('edit', fn(Oeuvre $oeuvre) => sprintf('%s - %s', $oeuvre->getNumInventaire(), $oeuvre->getTitre()))
            ->overrideTemplate('crud/edit', 'admin/oeuvre_edit.html.twig');
    }

    public static function getEntityFqcn(): string
    {
        return Oeuvre::class;
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
            $oeuvre->setNumInventaire($this->oeuvreRepository->getLastInventoryNumber() + 1);

            return $oeuvre;
        }

        return parent::createEntity($entityFqcn);
    }

    /*public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance
            ->setUpdatedBy($this->getUser());

        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::persistEntity($entityManager, $entityInstance);


        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }*/

    /**
     * Configure the actions for the OeuvreCrudController.
     *
     * @param Actions $actions
     * @return Actions
     */
    public function configureActions(Actions $actions): Actions
    {
        // Create a new action to generate a PDF of the Oeuvre entity.
        $pdfLink = Action::new('pdf', 'Exporter en PDF', 'fa fa-file-pdf')
            ->linkToRoute('pdf_oeuvre', function (Oeuvre $entity) {
                return ['id' => $entity->getId()];
            })
            ->setHtmlAttributes([
                'target' => '_blank',
            ])
            ->setCssClass('d-flex m-2');

        $pdfBtn = Action::new('pdf', 'Exporter en PDF', 'fa fa-file-pdf')
            ->linkToRoute('pdf_oeuvre', function (Oeuvre $entity) {
                return ['id' => $entity->getId()];
            })
            ->setHtmlAttributes([
                'target' => '_blank',
            ])
            ->setCssClass('btn btn-danger');

        // Create a new action to go back to the index page.
        $goBack = Action::new('goBack', 'Retourner à la liste', 'fa fa-arrow-left')
            ->linkToCrudAction('index')
            ->setCssClass('btn btn-secondary');

        // Create a new action to add a new location.
        $newLocationModal = Action::new('newLieu', 'Ajouter un lieu')
            ->linkToUrl('#')
            ->addCssClass('btn btn-secondary')
            ->setIcon('fa-fw fas fa-solid fa-location-dot')
            ->setHtmlAttributes([
                'id' => 'new-location-modal-action',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => "#modal-new-location"
            ]);

        $exportToCsv = Action::new('export_to_csv', 'Exporter en CSV')
            ->linkToRoute('app_list_to_csv', ['ids' => 'entity.getId()'])
            ->setHtmlAttributes([
                'target' => '_blank',
                'id' => 'export-to-csv-action',
                'override-data-bs-target' => '#modal-batch-action-csv',
            ])
            ->setIcon('fa fa-file-csv')
            ->setCssClass('btn btn-success')
            ->setTemplatePath('admin/button/action.html.twig');

        $exportToPdf = Action::new('export_to_pdf', 'Exporter en PDF')
            ->linkToRoute('app_list_to_pdf', ['ids' => 'entity.getId()'])
            ->setHtmlAttributes([
                'target' => '_blank',
                'id' => 'export-to-pdf-action',
                'override-data-bs-target' => '#modal-batch-action-pdf',
            ])
            ->setIcon('fa fa-file-pdf')
            ->setCssClass('btn btn-danger')
            ->setTemplatePath('admin/button/action.html.twig');

        $actions
            ->addBatchAction($exportToPdf)
            ->addBatchAction($exportToCsv)
            ->add(Crud::PAGE_INDEX, $pdfLink)
            ->update(Crud::PAGE_INDEX, Action::EDIT,
                function (Action $action) {
                    return $action
                        ->setLabel('Modifier/Visualiser')
                        ->setIcon('fa fa-pencil-alt')
                        ->addCssClass('d-flex m-2');
                }
            )
            ->update(Crud::PAGE_INDEX, Action::DELETE,
                function (Action $action) {
                    return $action
                        ->setIcon('fa fa-trash-alt')
                        ->addCssClass('d-flex m-2');
                }
            )
            ->add(Crud::PAGE_EDIT, $newLocationModal)
            ->add(Crud::PAGE_EDIT, $pdfBtn)
            ->add(Crud::PAGE_EDIT, $goBack);

        return parent::configureActions($actions);
    }

    public function configureAssets(Assets $assets): Assets
    {
        $assets = parent::configureAssets($assets);
        return $assets
            ->addJsFile(Asset::new('image-preview.js'))
            ->addAssetMapperEntry('modal-new-location')
            ->addAssetMapperEntry('modal-export-to-pdf')
            ->addAssetMapperEntry('modal-export-to-csv')
            ->addAssetMapperEntry('umanit-easyadmintree-tree-field');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('numInventaire')
            ->add('titre')
            ->add('sousTitre')
            ->add('dimensions')
            ->add('FirstYear')
            ->add('serie')
            ->add('description')
            ->add('commentairePublic')
            ->add('ArtworkCategory')
            ->add(HistoryFilter::new('oeuvreHistoriques', 'Historique'))
            ->add(BibliographyFilter::new('oeuvreBibliographies', 'Bibliographies'))
            ->add(ExhibitionFilter::new('oeuvreExpositions', 'Expositions'))
            ->add(LocationFilter::new('oeuvreStockages', 'Localisation'))
            ->add(ArtworkMediaFilter::new('ArtworkMedias', 'Médias'));
        //->add(EntityFilter::new('ArtworkMedias'));
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            FormField::addTab('Général'),
            FormField::addColumn('col-lg-4'),
            TextField::new('numInventaire', 'N°inv'),
            TextField::new('titre'),
            TextField::new('sousTitre', 'Sous-titre')
                ->stripTags()
                ->hideOnIndex(),
            TextField::new('serie', 'Titre de la série')
                ->stripTags()
                ->hideOnIndex(),
            FormField::addFieldset('Date de création'),
            ChoiceField::new('FirstMonth', 'Mois')
                ->setChoices($this->options->getMonthTextual())
                ->setColumns(4)
                ->hideOnIndex(),
            IntegerField::new('FirstYear', 'Année')
                ->setColumns(3)
                ->hideOnIndex(),
            BooleanField::new('FirstDateUncertain', 'Date 1 incertaine')
                ->hideOnIndex()
                ->addCssClass('p-0 date-uncertain')
                ->setColumns(5),
            ChoiceField::new('dateSeparator', 'Séparateur')
                ->hideOnIndex()
                ->setChoices($this->options->getDateSeparator()),
            ChoiceField::new('SecondMonth', 'Mois')
                ->hideOnIndex()
                ->setChoices($this->options->getMonthTextual())
                ->setColumns(4),
            IntegerField::new('SecondYear', 'Année')
                ->hideOnIndex()
                ->setColumns(3),
            BooleanField::new('SecondDateUncertain', 'Date 2 incertaine')
                ->hideOnIndex()
                ->addCssClass('p-0 date-uncertain')
                ->setColumns(5),
            TextField::new('DateComplement', 'Complément de date'),
            TextField::new('FirstYearAlt', 'Année')
                ->onlyOnIndex(),

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
                ->addJsFiles(Asset::fromEasyAdminAssetPackage('field-image.js'))
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
            TableField::new('oeuvreExpositions', 'Exposition de l\'oeuvre')
                ->setEntryType(ExpositionCollectionType::class)
                ->allowAdd()
                ->allowDelete()
                ->setEntryIsComplex()
                ->hideOnIndex(),
            FormField::addTab('Localisation'),
            TableField::new('oeuvreStockages', 'Dernière localisation ')
                ->setEntryType(StockageCollectionType::class)
                ->allowAdd()
                ->allowDelete()
                ->setEntryIsComplex(),
            FormField::addTab('Médias'),
            TableField::new('ArtworkMedias', 'Image de l\'oeuvre')
                ->setEntryType(ArtworkMediaType::class)
                ->setTemplatePath('admin/vich_image_collection.html.twig')
                ->allowAdd()
                ->allowDelete()
                ->setEntryIsComplex(),
        ];
    }
}
