<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Movie;
use App\Entity\Genre;
use App\Entity\Person;
use App\Repository\DoctrineGenreRepository;
use App\Repository\DoctrinePersonRepository;
use App\Repository\DTO\ImportedCSVData;
use Doctrine\Persistence\ManagerRegistry;

final class ImportCSVDataService
{
    public function __construct(
        private DoctrinePersonRepository $personRepository,
        private DoctrineGenreRepository $genreRepository,
        private ManagerRegistry $managerRegistry
    )
    {
    }

    /**
     * @param ImportedCSVData[] $data
     */
    public function execute(array $data): void
    {
        $sqlLogger = $this->managerRegistry->getConnection()->getConfiguration()->getSQLLogger();
        $this->managerRegistry->getConnection()->getConfiguration()->setSQLLogger(null);

        foreach ($data as $item) {
            $actors = $this->getActors($item->actors);
            $directors = $this->getDirectors($item->directors);
            $genres = $this->getGenres($item->genres);
            $producer = $this->getProducer($item->producer);

            $film = new Movie();
            $film->setTitle($item->title);
            $film->setDuration($item->duration);
            $film->setPublicationDate($item->publicationDate);
            $film->setGenres($genres);
            $film->setActors($actors);
            $film->setDirectors($directors);
            $film->setProducer($producer);

            $this->managerRegistry->getManager()->persist($film);
        }

        $this->managerRegistry->getManager()->flush();
        $this->managerRegistry->getManager()->clear();

        $this->managerRegistry->getConnection()->getConfiguration()->setSQLLogger($sqlLogger);
    }

    /**
     * @param string[] $actors
     * @return Person[]
     */
    private function getActors(array $actors): array
    {
        $result = [];

        foreach ($actors as $actorName) {
            $actorName = trim($actorName);
            $actor = $this->personRepository->findOneBy(['name' => $actorName]);

            $result[] = $actor ?? $this->saveActor($actorName);
        }

        return $result;
    }

    /**
     * @param string[] $directors
     * @return Person[]
     */
    private function getDirectors(array $directors): array
    {
        $result = [];

        foreach ($directors as $directorName) {
            $directorName = trim($directorName);
            $director = $this->personRepository->findOneBy(['name' => $directorName]);

            $result[] = $director ?? $this->saveDirector($directorName);
        }

        return $result;
    }

    /**
     * @param string[] $genres
     * @return Genre[]
     */
    private function getGenres(array $genres): array
    {
        $result = [];

        foreach ($genres as $genreName) {
            $genreName = trim($genreName);
            $genre = $this->genreRepository->findOneBy(['name' => $genreName]);

            $result[] = $genre ?? $this->saveGenre($genreName);
        }

        return $result;
    }

    private function getProducer(string $producerName): Person
    {
        $producerName = trim($producerName);
        $producer = $this->personRepository->findOneBy(['name' => $producerName]);

        return $producer ?? $this->saveProducer($producerName);
    }

    private function saveGenre(string $genreName): Genre
    {
        $genre = new Genre($genreName);
        $this->managerRegistry->getManager()->persist($genre);
        $this->managerRegistry->getManager()->flush();
        return $genre;
    }

    private function saveProducer(string $producerName): Person
    {
        $producer = new Person($producerName);
        $this->managerRegistry->getManager()->persist($producer);
        $this->managerRegistry->getManager()->flush();
        return $producer;
    }

    private function saveDirector(string $directorName): Person
    {
        $director = new Person($directorName);
        $this->managerRegistry->getManager()->persist($director);
        $this->managerRegistry->getManager()->flush();
        return $director;
    }

    private function saveActor(string $actorName): Person
    {
        $actor = new Person($actorName);
        $this->managerRegistry->getManager()->persist($actor);
        $this->managerRegistry->getManager()->flush();
        return $actor;
    }
}