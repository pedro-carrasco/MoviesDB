<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\DoctrineActorRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctrineActorRepository::class)]
final class Actor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'date')]
    private DateTime $birth_date;

    #[ORM\Column(type: 'date')]
    private DateTime $death_date;

    #[ORM\ManyToOne(targetEntity: City::class)]
    private City $city;

}