<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\DoctrineFilmRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: DoctrineFilmRepository::class)]
final class Film
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'date')]
    private DateTime $publicationDate;

    #[ORM\Column(type: 'integer')]
    private int $duration;

    #[ORM\ManyToMany(targetEntity: Genre::class, cascade: ['persist'])]
    private $genres;

    #[ORM\ManyToOne(targetEntity: Producer::class, cascade: ['persist'])]
    private Producer $producer;

    #[ORM\ManyToMany(targetEntity: Actor::class, cascade: ['persist'])]
    private $actors;

    #[ORM\ManyToMany(targetEntity: Director::class, cascade: ['persist'])]
    private $directors;

    #[Pure]
    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->actors = new ArrayCollection();
        $this->directors = new ArrayCollection();
    }


    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function publicationDate(): DateTime
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(DateTime $publicationDate): void
    {
        $this->publicationDate = $publicationDate;
    }

    public function duration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    public function genres(): ArrayCollection
    {
        return $this->genres;
    }

    public function genresList(): string
    {
        return implode(', ', $this->genres->toArray());
    }

    public function setGenres(array $genres): void
    {
        foreach ($genres as $genre) {
            $this->genres->add($genre);
        }
    }

    public function producer(): Producer
    {
        return $this->producer;
    }

    public function setProducer(Producer $producer): void
    {
        $this->producer = $producer;
    }

    public function actors(): ArrayCollection
    {
        return $this->actors;
    }

    public function setActors(array $actors): void
    {
        foreach ($actors as $actor) {
            $this->actors->add($actor);
        }
    }

    public function actorsList(): string
    {
        return implode(', ', $this->actors->toArray());
    }

    public function directors(): ArrayCollection
    {
        return $this->directors;
    }

    public function directorsList(): string
    {
        return implode(', ', $this->directors->toArray());
    }

    public function setDirectors(array $directors): void
    {
        foreach ($directors as $director) {
            $this->directors->add($director);
        }
    }
}