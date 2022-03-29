<?php
declare(strict_types=1);

namespace App\Repository\DTO;

use DateTime;

final class ImportedCSVData
{
    public function __construct(
        public string $title,
        public ?DateTime $publicationDate,
        public array $genres,
        public int $duration,
        public array $directors,
        public string $producer,
        public array $actors
    )
    {
    }
}