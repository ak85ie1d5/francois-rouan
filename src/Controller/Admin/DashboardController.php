<?php

namespace App\Controller\Admin;

use App\Entity\ArtworkCategory;
use App\Entity\Lieu;
use App\Entity\Oeuvre;
use App\Entity\OeuvreBibliographie;
use App\Entity\OeuvreExposition;
use App\Entity\OeuvreHistorique;
use App\Entity\ArtworkMedia;
use App\Entity\OeuvreStockage;
use App\Entity\Options;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class DashboardController extends AbstractDashboardController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $OeuvreRepository = $this->entityManager->getRepository(Oeuvre::class);

        // Count artworks by category
        $countArtworksByCategory = $OeuvreRepository->countArtworksByCategory();
        // Count artworks by year
        $countArtworksByYear = $OeuvreRepository->countArtworksByYear();

        $OeuvreStockageRepository = $this->entityManager->getRepository(OeuvreStockage::class);

        // Count localisation type
        $countLocalisationType = $OeuvreStockageRepository->countLocalisationType();

        // Count last artworks localisation
        $countLastArtworksLocalisation = $OeuvreStockageRepository->countLastArtworksLocalisation();

        return $this->render('admin/dashboard.html.twig', [
            'count_total_artworks' => $OeuvreRepository->countTotalArtworks(),
            'disk_space' => [
                'total' => number_format(disk_total_space($this->getParameter('kernel.project_dir')) / 1073741824, 1, ',', ' '),
                'free' => disk_free_space('/') / 1073741824,
                'used' => number_format((disk_total_space('/') - disk_free_space('/')) / 1073741824, 1, ',', ' ')
            ],
            'count_localisation_type' => [
                'labels' => array_column($countLocalisationType, 'type_name'),
                'datasets' => array_column($countLocalisationType, 'sum')
            ],
            'count_artworks_by_category' => [
                'labels' => array_column($countArtworksByCategory, 'category_name'),
                'datasets' => array_column($countArtworksByCategory, 'artwork_count')
            ],
            'count_artworks_by_year' => [
                'labels' => array_column($countArtworksByYear, 'first_year'),
                'datasets' => array_column($countArtworksByYear, 'sum')
            ],

            'count_last_artworks_localisation' => [
                'labels' => array_column($countLastArtworksLocalisation, 'nom'),
                'datasets' => array_column($countLastArtworksLocalisation, 'sum')
            ]
        ]);
    }

    // Add the custom form theme
    public function configureCrud(): Crud
    {
        $crud = parent::configureCrud();

        return $crud
            ->setPageTitle('index', 'Liste des %entity_label_plural%')
            ->setPageTitle('new', 'Créer un %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier l\'%entity_label_singular%');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Theta Galerie')
            ->renderContentMaximized();
    }

    public function configureActions(): Actions
    {
        $actions = parent::configureActions();

        return $actions
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Sauvegarder et quitter');
            });
    }

    public function configureAssets(): Assets
    {
        $assets = parent::configureAssets();

        return $assets
            ->addAssetMapperEntry('app')
            ->addAssetMapperEntry('chart');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-dashboard');
        yield MenuItem::linkToCrud('Oeuvres', 'fas fa-solid fa-brush', Oeuvre::class);
        yield MenuItem::linkToCrud('Catégories d\'oeuvres', 'fas fa-list', ArtworkCategory::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Lieux', 'fas fa-solid fa-location-dot', Lieu::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', Utilisateur::class);

        yield MenuItem::section('Super Users')->setPermission('ROLE_SUPERADMIN');
        yield MenuItem::linkToCrud('Oeuvre Historique', 'fa-solid fa-clock-rotate-left', OeuvreHistorique::class)->setPermission('ROLE_SUPERADMIN');
        yield MenuItem::linkToCrud('Oeuvre Bibliographie', 'fa-solid fa-book', OeuvreBibliographie::class)->setPermission('ROLE_SUPERADMIN');
        yield MenuItem::linkToCrud('Oeuvre Exposition', 'fa-solid fa-building-columns', OeuvreExposition::class)->setPermission('ROLE_SUPERADMIN');
        yield MenuItem::linkToCrud('Oeuvre Localisation', 'fas fa-solid fa-location-dot', OeuvreStockage::class)->setPermission('ROLE_SUPERADMIN');
        yield MenuItem::linkToCrud('Oeuvre Media', 'fa-solid fa-image', ArtworkMedia::class)->setPermission('ROLE_SUPERADMIN');
        yield MenuItem::linkToCrud('Options', 'fa fa-cog', Options::class)->setPermission('ROLE_SUPERADMIN');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->addMenuItems([
                MenuItem::linkToCrud('Profile', '', Utilisateur::class)->setAction('edit')->setEntityId($user->getId()),
            ]);
    }
}
