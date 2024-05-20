<?php

namespace App\Utils;

class DateChoices
{
    public static function getDayChoices(): array
    {
        return range(0, 31);
    }

    public static function getMonthChoices(): array
    {
        return [
            '' => 0,
            'Janvier' => 1,
            'Février' => 2,
            'Mars' => 3,
            'Avril' => 4,
            'Mai' => 5,
            'Juin' => 6,
            'Juillet' => 7,
            'Août' => 8,
            'Septembre' => 9,
            'Octobre' => 10,
            'Novembre' => 11,
            'Décembre' => 12,
        ];
    }

    public static function getLocalisationTypes(): array
    {
        return [
            'Inconnu' => 0,
            'Interne' => 2,
            'Externe' => 3,
        ];
    }

    public static function getLocalisationDetails(): array
    {
        return [
            '' => 0,
            'Collection publique' => 2,
            'Collection particulière' => 3,
            'Consignation' => 4
        ];
    }
}