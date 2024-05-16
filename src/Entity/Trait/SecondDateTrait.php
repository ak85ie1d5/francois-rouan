<?php

namespace App\Entity\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SecondDateTrait
{
    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $SecondDay = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $SecondMonth = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $SecondYear = null;

    public function getSecondDay(): ?int
    {
        return $this->SecondDay;
    }

    public function setSecondDay(?int $SecondDay): static
    {
        $this->SecondDay = $SecondDay;

        return $this;
    }

    public function getSecondMonth(): ?int
    {
        return $this->SecondMonth;
    }

    public function setSecondMonth(?int $SecondMonth): static
    {
        $this->SecondMonth = $SecondMonth;

        return $this;
    }

    public function getSecondYear(): int
    {
        return $this->SecondYear;
    }

    public function setSecondYear(int $Secondyear): static
    {
        $this->SecondYear = $Secondyear;

        return $this;
    }

    public function getSecondDate(): ?\DateTime
    {
        if ($this->SecondYear && $this->SecondMonth && $this->SecondDay) {
            return new \DateTime(sprintf('%d-%d-%d', $this->SecondYear, $this->SecondMonth, $this->SecondDay));
        }

        return null;
    }
}