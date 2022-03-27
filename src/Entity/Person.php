<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\DoctrinePersonRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctrinePersonRepository::class)]
#[ORM\Index(columns: ["name"], name: "person_name_idx")]
#[ORM\Cache('READ_ONLY')]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?DateTime $birthDate;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?DateTime $deathDate;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $city;

    #[ORM\OneToMany(mappedBy: "producer", targetEntity: Movie::class, fetch: 'LAZY')]
    private $moviesProduced;

    #[ORM\ManyToMany(mappedBy: "directors", targetEntity: Movie::class, fetch: 'LAZY')]
    private $moviesDirected;

    #[ORM\ManyToMany(mappedBy: "actors", targetEntity: Movie::class, fetch: 'LAZY')]
    private $moviesAsActor;

    public function __construct(
        string $name,
        ?DateTime $birthDate = null,
        ?DateTime $deathDate = null,
        string $city = ''
    ) {
        $this->name = $name;
        $this->birthDate = $birthDate;
        $this->deathDate = $deathDate;
        $this->city = $city;
    }


    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function birthDate(): ?DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(?DateTime $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function deathDate(): ?DateTime
    {
        return $this->deathDate;
    }

    public function setDeathDate(?DateTime $deathDate): void
    {
        $this->deathDate = $deathDate;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function moviesAsActor(): string
    {
        return implode(', ', $this->moviesAsActor->toArray());
    }
}