<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\DoctrineFilmRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
    private DateTime $publication_date;

    #[ORM\Column(type: 'integer')]
    private int $duration;

    #[ORM\ManyToMany(targetEntity: Genre::class)]
    private ArrayCollection $genres;

    #[ORM\ManyToOne(targetEntity: Producer::class)]
    private Producer $producer;

    #[ORM\ManyToMany(targetEntity: Actor::class)]
    private ArrayCollection $actors;

    #[ORM\ManyToMany(targetEntity: Director::class)]
    private ArrayCollection $directors;
}