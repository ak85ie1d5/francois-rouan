<?php

namespace App\Service;

use App\Repository\OptionsRepository;

class Options
{
    private OptionsRepository $optionsRepository;

    private array $locationTypes = [];

    private array $locationDetails = [];

    private array $monthTextual = [];

    private array $dateSeparator = [];

    public function __construct(OptionsRepository $optionsRepository)
    {
        $this->optionsRepository = $optionsRepository;
    }

    public function getLocationTypes(): array
    {
        if ($this->optionsRepository->findOneBy(['name' => 'location_types'])) {
            $this->locationTypes = array_flip($this->optionsRepository->findOneBy(['name' => 'location_types'])->getValue());
        }

        return $this->locationTypes;
    }

    public function getLocationDetails(): array
    {
        if ($this->optionsRepository->findOneBy(['name' => 'location_details'])) {
            $this->locationDetails = array_flip($this->optionsRepository->findOneBy(['name' => 'location_details'])->getValue());
        }

        return $this->locationDetails;
    }

    public function getMonthTextual(): array
    {
        if ($this->optionsRepository->findOneBy(['name' => 'month_textual'])) {
            $this->monthTextual = array_flip($this->optionsRepository->findOneBy(['name' => 'month_textual'])->getValue());
        }

        return $this->monthTextual;
    }

    public function getDayNumeric(): array
    {
        return range(0, 31);
    }

    public function getDateSeparator(): array
    {
        if ($this->optionsRepository->findOneBy(['name' => 'date_separator'])) {
            $this->dateSeparator = array_flip($this->optionsRepository->findOneBy(['name' => 'date_separator'])->getValue());
        }

        return $this->dateSeparator;
    }
}