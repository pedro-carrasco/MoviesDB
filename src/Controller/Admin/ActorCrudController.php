<?php

namespace App\Controller\Admin;

use App\Entity\Person;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ActorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Person::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->remove(Crud::PAGE_INDEX, Action::NEW);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Actores')
            ->setPageTitle('edit', fn(Person $actor) => sprintf('Actor: <b>%s</b>', $actor->name()))
            ->setSearchFields([
                'name',
            ]);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nombre'),
            TextField::new('listMoviesAsActor', 'Películas en las que participa')->hideOnDetail()->hideOnForm(),
            TextField::new('listMoviesAsDirector', 'Películas dirigidas')->hideOnDetail()->hideOnForm(),
            TextField::new('listMoviesAsProducer', 'Películas producidas')->hideOnDetail()->hideOnForm(),
            TextField::new('birthDate', 'Fecha de nacimiento')->hideOnIndex(),
            TextField::new('deathDate', 'Fecha de fallecimiento')->hideOnIndex(),
            TextField::new('city', 'Lugar de nacimiento')->hideOnIndex(),
        ];
    }


    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('name');
    }

    public function createIndexQueryBuilder(
        SearchDto $searchDto,
        EntityDto $entityDto,
        FieldCollection $fields,
        FilterCollection $filters
    ): QueryBuilder {
        return parent::createIndexQueryBuilder($searchDto,
            $entityDto,
            $fields,
            $filters)
            ->innerJoin('entity.moviesAsActor', 'movies_as_actor');

    }
}
