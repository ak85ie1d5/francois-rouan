<?php

namespace App\Controller\Admin;

use App\Admin\Field\TableField;
use App\Admin\Field\TreeField;
use App\Controller\Admin\Filter\ArtworkCategoryFilter;
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
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Vich\UploaderBundle\Storage\StorageInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class OeuvreCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;

    private $storage;

    private $options;

    private $oeuvreRepository;

    private RequestStack $requestStack;

    /**
     * Inject the StorageInterface instance into the controller.
     *
     * OeuvreCrudController constructor.
     * @param StorageInterface $storage
     * @param AdminUrlGenerator $adminUrlGenerator
     * @param Options $options
     * @param OeuvreRepository $oeuvreRepository
     * @param RequestStack $requestStack
     */
    public function __construct(StorageInterface $storage, AdminUrlGenerator $adminUrlGenerator, Options $options, OeuvreRepository $oeuvreRepository, RequestStack $requestStack)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->storage = $storage;
        $this->options = $options;
        $this->oeuvreRepository = $oeuvreRepository;
        $this->requestStack = $requestStack;
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

    /**
     * Configure the actions for the OeuvreCrudController.
     *
     * @param Actions $actions
     * @return Actions
     */
    public function configureActions(Actions $actions): Actions
    {
        $httpReferer = $_SERVER['HTTP_REFERER'] ?? '';
        $query = parse_url($httpReferer, PHP_URL_QUERY) ?? '';

        parse_str($query, $params);

        $page = (isset($params['page']) && ctype_digit((string) $params['page']) && (int) $params['page'] >= 1)
            ? (int) $params['page']
            : 1;

        // Create a new action to generate a PDF of the Oeuvre entity.
        $pdfLink = Action::new('pdf', 'Exporter&nbsp;en&nbsp;PDF', 'fa fa-file-pdf')
            ->linkToRoute('pdf_oeuvre', function (Oeuvre $entity) {
                return ['id' => $entity->getId()];
            })
            ->setHtmlAttributes([
                'target' => '_blank',
            ])
            ->asTextLink()
            ->asPrimaryAction()
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
            ->linkToUrl(
                $this->adminUrlGenerator
                    ->unsetAll()
                    ->setController(self::class)
                    ->setAction(Action::INDEX)
                    ->set('page', $page)
                    ->generateUrl()
            )
            ->setCssClass('btn btn-secondary action-goBack');

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

        $uncheckAll = Action::new('uncheckAll', '')
            ->linkToUrl('#')
            ->setHtmlAttributes([
                'id' => 'uncheck-all-action',
                'title' => 'Désélectionner toutes les lignes',
                'override-data-bs-target' => '#modal-batch-action-uncheck-all',
            ])
            ->setIcon('fa fa-check')
            ->addCssClass('btn btn-light')
            ->setTemplatePath('admin/button/action.html.twig');

        $exportToCsv = Action::new('export_to_csv', 'Exporter en CSV')
            ->linkToRoute('app_list_to_csv')
            ->setHtmlAttributes([
                'target' => '_blank',
                'id' => 'export-to-csv-action',
                'override-data-bs-target' => '#modal-batch-action-csv',
            ])
            ->setIcon('fa fa-file-csv')
            ->setCssClass('btn btn-success')
            ->setTemplatePath('admin/button/action.html.twig');

        $exportToZip = Action::new('export_to_zip', 'Exporter dans un ZIP')
            ->linkToRoute('app_list_to_zip')
            ->setHtmlAttributes([
                'target' => '_blank',
                'id' => 'export-to-zip-action',
                'override-data-bs-target' => '#modal-batch-action-pdf',
            ])
            ->setIcon('fa fa-file-zipper')
            ->setCssClass('btn btn-warning')
            ->setTemplatePath('admin/button/action.html.twig');

        $exportToPdf = Action::new('export_to_pdf', 'Exporter en PDF')
            ->linkToRoute('app_list_to_pdf')
            ->setHtmlAttributes([
                'target' => '_blank',
                'id' => 'export-to-pdf-action',
                'override-data-bs-target' => '#modal-batch-action-pdf',
            ])
            ->setIcon('fa fa-file-pdf')
            ->setCssClass('btn btn-danger')
            ->setTemplatePath('admin/button/action.html.twig');

        $actions
            ->addBatchAction($exportToCsv)
            ->addBatchAction($exportToPdf)
            ->addBatchAction($exportToZip)
            ->addBatchAction($uncheckAll)

            ->add(Crud::PAGE_INDEX, $pdfLink)
            ->update(Crud::PAGE_INDEX, Action::EDIT,
                function (Action $action) {
                    return $action
                        ->setLabel('Modifier&nbsp;/&nbsp;Visualiser')
                        ->setIcon('fa fa-pencil-alt')
                        ->asTextLink()
                        ->asPrimaryAction()
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
            ->reorder(Crud::PAGE_INDEX, ['export_to_csv', 'export_to_pdf', 'export_to_zip', 'uncheckAll', Action::BATCH_DELETE, 'pdf', Action::EDIT, Action::DELETE])
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
            ->addJsFile(Asset::new('field-depend-on.js'))
            ->addAssetMapperEntry('scroll-auto')
            ->addAssetMapperEntry('modal-new-location')
            ->addAssetMapperEntry('modal-export-to-pdf')
            ->addAssetMapperEntry('modal-export-to-csv')
            ->addAssetMapperEntry('modal-uncheck-all')
            ->addAssetMapperEntry('selection-multiple')
            ->addAssetMapperEntry('draggable-collection')
            ->addAssetMapperEntry('table-field-sortable')
            ->addCssFile(Asset::new('styles/tree-field.css'))
            ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('numInventaire')
            ->add('titre')
            ->add(TextFilter::new('sousTitre', 'Sous-titre'))
            ->add('dimensions')
            ->add(TextFilter::new('DimensionWithFrame', 'Dimensions avec cadre'))
            ->add(NumericFilter::new('FirstYear', 'Année'))
            ->add(TextFilter::new('serie', 'Titre de la série'))
            ->add('description')
            ->add(TextFilter::new('commentairePublic', 'Commentaire public'))
            ->add(ArtworkCategoryFilter::new('ArtworkCategory', 'Catégories'))
            ->add(HistoryFilter::new('oeuvreHistoriques', 'Historique'))
            ->add(BibliographyFilter::new('oeuvreBibliographies', 'Bibliographies'))
            ->add(ExhibitionFilter::new('oeuvreExpositions', 'Expositions'))
            ->add(LocationFilter::new('oeuvreStockages', 'Localisation'))
            ->add(ArtworkMediaFilter::new('ArtworkMedias', 'Médias'));
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
            TextField::new('DimensionWithFrame', 'Dimensions avec cadre')
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

    /**
     * Override the edit action to store the current list page in session.
     * This allows restoring the correct page when returning to the list.
     * The page is only stored on GET requests (form display), not on POST (form submit).
     *
     * @param AdminContext $context
     * @return KeyValueStore|Response
     */
    public function edit(AdminContext $context): KeyValueStore|Response
    {
        // On ne stocke la page que lors de l'affichage du formulaire, pas au submit
        if ($context->getRequest()->isMethod('GET')) {
            $httpReferer = $context->getRequest()->headers->get('referer') ?? '';
            $query = parse_url($httpReferer, PHP_URL_QUERY) ?? '';
            parse_str($query, $params);

            $page = (isset($params['page']) && ctype_digit((string) $params['page']) && (int) $params['page'] >= 1)
                ? (int) $params['page']
                : 1;

            $this->requestStack->getSession()->set('oeuvre_list_page', $page);
        }

        return parent::edit($context);
    }

    /**
     * Override the redirect response after saving an entity.
     * When the "Save and return" button is clicked, redirects to the list page
     * that was stored in session when the edit form was opened, preserving pagination.
     *
     * @param AdminContext $context
     * @param string $action
     * @return RedirectResponse
     */
    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'] ?? null;

        if ('saveAndReturn' === $submitButtonName) {
            $page = $this->requestStack->getSession()->get('oeuvre_list_page', 1);

            return $this->redirectToRoute('admin_oeuvre_index', ['page' => $page]);
        }

        return parent::getRedirectResponseAfterSave($context, $action);
    }
}
