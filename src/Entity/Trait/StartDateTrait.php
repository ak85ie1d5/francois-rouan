<?php

namespace App\Entity\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait StartDateTrait
{
    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $day = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $month = null;

    #[ORM\Column(type: Types::INTEGER)]
    private int $year;

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(?int $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(?int $month): static
    {
        $this->month = $month;

        return $this;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        if ($this->year && $this->month && $this->day) {
            return new \DateTime(sprintf('%d-%d-%d', $this->year, $this->month, $this->day));
        }

        return null;
    }
}