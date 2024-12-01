<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use App\Entity\AnimalCategory;
use App\Entity\AnimalDiet;
use App\Entity\AnimalFamily;
use App\Entity\Enclosure;
use App\Entity\Event;
use App\Entity\Registration;
use App\Entity\Species;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ZooTechPark');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Evénements', 'fas fa-list', Event::class);
        yield MenuItem::linkToCrud('Espèces', 'fas fa-list', Species::class);
        yield MenuItem::linkToCrud('Inscription', 'fas fa-list', Registration::class);
        yield MenuItem::linkToCrud('Régimes', 'fas fa-list', AnimalDiet::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-list', AnimalCategory::class);
        yield MenuItem::linkToCrud('Animaux', 'fas fa-list', Animal::class);
        yield MenuItem::linkToCrud('Familles', 'fas fa-list', AnimalFamily::class);
        yield MenuItem::linkToCrud('Enclos', 'fas fa-list', Enclosure::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Evénements', 'fas fa-list', Event::class);
        // yield MenuItem::linkToCrud('ajouter pour chaque crud', 'fas fa-list', EntityClass::class);
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addCssFile('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined');
    }
}
