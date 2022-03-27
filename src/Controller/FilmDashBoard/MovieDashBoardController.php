<?php
declare(strict_types=1);

namespace App\Controller\FilmDashBoard;

use App\Controller\Admin\PersonCrudController;
use App\Controller\Admin\MovieCrudController;
use App\Entity\Movie;
use App\Entity\Person;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class MovieDashBoardController extends AbstractDashboardController
{
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Movies Database');
    }

    #[Route('/')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(MovieCrudController::class)->generateUrl());
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Inicio', 'fa fa-home'),
            MenuItem::section('Menú'),
            MenuItem::linkToCrud('Películas', 'fa fa-tags', Movie::class),
            MenuItem::linkToCrud('Actores, Directores y Productores', 'fa fa-solid fa-theater-masks', Person::class)
        ];
    }
}