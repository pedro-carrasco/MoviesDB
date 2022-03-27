<?php

namespace App\Controller\Admin;

use App\Entity\Person;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ActorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Person::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Actores')
            ->setPageTitle('detail', fn (Person $actor) => sprintf('Actor: <b>%s</b>', $actor->name()))
            ->setSearchFields([
                'name',
            ]);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Título'),
            TextField::new('moviesAsActor', 'Películas en las que participa')->hideOnDetail()->hideOnForm(),
            TextField::new('birthDate', 'Fecha de nacimiento'),
            TextField::new('deathDate', 'Fecha de fallecimiento'),
            TextField::new('city', 'Lugar de nacimiento'),
        ];
    }
}
