<?php

namespace App\Entity;

use App\Repository\DoctrineCityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:DoctrineCityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $country_name;
}
