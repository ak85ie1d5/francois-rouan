<?php

namespace App\Controller\Admin;

use App\Entity\ArtworkCategory;
use App\Entity\Lieu;
use App\Entity\Oeuvre;
use App\Entity\OeuvreBibliographie;
use App\Entity\OeuvreExposition;
use App\Entity\OeuvreHistorique;
use App\Entity\OeuvreMediaTest;
use App\Entity\OeuvreStockage;
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
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $repository = $this->entityManager->getRepository(Lieu::class);
        $lieux = $repository->findAll();
        return $this->render('admin/dashboard.html.twig', [
            'nb_artworks' => "Nombre d'oeuvre: 3758",
            'lieux' => $lieux,
        ]);

        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
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
            ->addCssFile('build/app.css');
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
        yield MenuItem::linkToCrud('Oeuvre Media', 'fa-solid fa-image', OeuvreMediaTest::class)->setPermission('ROLE_SUPERADMIN');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->addMenuItems([
                MenuItem::linkToCrud('Profile', '', Utilisateur::class)->setAction('edit')->setEntityId($user->getId()),
            ]);
    }
}
