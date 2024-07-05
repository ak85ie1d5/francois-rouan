<?php

namespace App\Entity\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait FirstDateTrait
{
    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $FirstDay = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $FirstMonth = null;

    #[ORM\Column(type: Types::INTEGER)]
    private int $FirstYear;


    public function getFirstDay(): ?int
    {
        return $this->FirstDay;
    }

    public function setFirstDay(?int $FirstDay): static
    {
        $this->FirstDay = $FirstDay;

        return $this;
    }

    public function getFirstMonth(): ?int
    {
        return $this->FirstMonth;
    }

    public function setFirstMonth(?int $FirstMonth): static
    {
        $this->FirstMonth = $FirstMonth;

        return $this;
    }

    public function getFirstYear(): int
    {
        return $this->FirstYear;
    }

    public function setFirstYear(int $Firstyear): static
    {
        $this->FirstYear = $Firstyear;

        return $this;
    }
}