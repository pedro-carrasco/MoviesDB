<?php
declare(strict_types=1);

namespace App\Controller\FilmDashBoard;

use App\Controller\Admin\FilmCrudController;
use App\Entity\Actor;
use App\Entity\Director;
use App\Entity\Film;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class FilmDashBoardController extends AbstractDashboardController
{
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Films DB');
    }

    #[Route('/')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(FilmCrudController::class)->generateUrl());
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Inicio', 'fa fa-home'),
            MenuItem::section('Menú'),
            MenuItem::linkToCrud('Películas', 'fa fa-tags', Film::class),
            MenuItem::linkToCrud('Actores', 'fa fa-solid fa-theater-masks', Actor::class),
            MenuItem::linkToCrud('Directores', 'fa fa-solid fa-video', Director::class),
        ];
    }
}