<?php
declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DoctrineDirectorRepository;

#[ORM\Entity(repositoryClass: DoctrineDirectorRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE')]
final class Director
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?DateTime $birthDate;

    public function __construct(string $name, ?DateTime $birthDate = null)
    {
        $this->name = $name;
        $this->birthDate = $birthDate;
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

    public function __toString(): string
    {
        return $this->name;
    }


}