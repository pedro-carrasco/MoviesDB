<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Actor;
use App\Entity\Director;
use App\Entity\Film;
use App\Entity\Genre;
use App\Entity\Producer;
use App\Repository\DoctrineActorRepository;
use App\Repository\DoctrineDirectorRepository;
use App\Repository\DoctrineFilmRepository;
use App\Repository\DoctrineGenreRepository;
use App\Repository\DoctrineProducerRepository;
use App\Repository\DTO\ImportedCSVData;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Config\Resource\DirectoryResource;

final class ImportCSVDataService
{
    public function __construct(
        private DoctrineActorRepository $actorRepository,
        private DoctrineGenreRepository $genreRepository,
        private DoctrineDirectorRepository $directorRepository,
        private DoctrineProducerRepository $producerRepository,
        private ManagerRegistry $managerRegistry
    )
    {
    }

    /**
     * @param ImportedCSVData[] $data
     */
    public function execute(array $data): void
    {
        foreach ($data as $item) {
            $actors = $this->getActors($item->actors);
            $directors = $this->getDirectors($item->directors);
            $genres = $this->getGenres($item->genres);
            $producer = $this->getProducer($item->producer);

            $film = new Film();
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
    }

    /**
     * @param string[] $actors
     * @return Actor[]
     */
    private function getActors(array $actors): array
    {
        $result = [];

        foreach ($actors as $actorName) {
            $actorName = trim($actorName);
            $actor = $this->actorRepository->findOneBy(['name' => $actorName]);

            $result[] = $actor ?? $this->saveActor($actorName);
        }

        return $result;
    }

    /**
     * @param string[] $directors
     * @return Director[]
     */
    private function getDirectors(array $directors)
    {
        $result = [];

        foreach ($directors as $directorName) {
            $directorName = trim($directorName);
            $director = $this->directorRepository->findOneBy(['name' => $directorName]);

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

    private function getProducer(string $producerName): Producer
    {
        $producerName = trim($producerName);
        $producer = $this->producerRepository->findOneBy(['name' => $producerName]);

        return $producer ?? $this->saveProducer($producerName);
    }

    private function saveGenre(string $genreName): Genre
    {
        $genre = new Genre($genreName);
        $this->managerRegistry->getManager()->persist($genre);
        $this->managerRegistry->getManager()->flush($genre);
        return $genre;
    }

    private function saveProducer(string $producerName): Producer
    {
        $producer = new Producer($producerName);
        $this->managerRegistry->getManager()->persist($producer);
        $this->managerRegistry->getManager()->flush($producer);
        return $producer;
    }

    private function saveDirector(string $directorName): Director
    {
        $director = new Director($directorName);
        $this->managerRegistry->getManager()->persist($director);
        $this->managerRegistry->getManager()->flush($director);
        return $director;
    }

    private function saveActor(string $actorName): Actor
    {
        $actor = new Actor($actorName);
        $this->managerRegistry->getManager()->persist($actor);
        $this->managerRegistry->getManager()->flush($actor);
        return $actor;
    }
}