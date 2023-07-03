<?php

namespace App\Controller\Admin;

use App\Entity\Horaire;
use App\Entity\ImagePlats;
use App\Controller\Admin\ImagePlatsCrudController;
use App\Entity\Menu;
use App\Entity\Plat;
use App\Entity\Reservation;
use App\Entity\User;
use App\Repository\ReservationRepository;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
        
    }
       
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        
        
        $url = $this->adminUrlGenerator
         ->setController(ReservationCrudController::class)
         ->generateUrl();
         return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Quai Antic');
    }

    public function configureMenuItems(): iterable
    {
    
        yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'app_home');
        yield MenuItem::linkToCrud('Reservation', 'fas fa-calendar-days', Reservation::class);
        yield MenuItem::linkToCrud('Images des plats', 'fas fa-image', ImagePlats::class);
        yield MenuItem::linkToCrud('Plats', 'fas fa-utensils', Plat::class);
        yield MenuItem::linkToCrud('Menus', 'fas fa-bars', Menu::class);
        yield MenuItem::linkToCrud('Horaires', 'fas fa-clock', Horaire::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        

    }
}
