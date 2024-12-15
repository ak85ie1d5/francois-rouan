<?php

namespace App\Service;

use App\Entity\Options;
use App\Entity\Oeuvre;
use Doctrine\ORM\EntityManagerInterface;

class CsvExportService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Generate an array of data from the given `oeuvre` IDs and fields for a CSV export.
     *
     * @param array $ids
     * @param array $fields
     * @return string
     */
    public function generateCsv(array $ids, array $fields): string
    {
        $artworks = $this->entityManager->getRepository(Oeuvre::class)->findBy(['id' => $ids]);
        $multipleLastLocalisation = $this->entityManager->getRepository(Oeuvre::class)->getMultipleLastLocalisation($ids);
        $monthTextual = $this->entityManager->getRepository(Options::class)->findOneBy(['name' => 'month_textual'])->getValue();

        $csvData = [];

        // Add the header row
        $csvData[] = $fields;

        foreach ($artworks as $artwork) {
            $row = [];
            foreach ($fields as $field) {
                $getter = 'get'.ucfirst($field);

                if (method_exists($artwork, $getter)) {
                    $value = $artwork->$getter();

                    // Remove line breaks from description and commentairePublic fields
                    if ($field === 'description' || $field === 'commentairePublic') {
                        $value = str_replace(["\r", "\n", ";"], ' ', $value);
                    }

                    if ($field === 'FirstMonth') {
                        $value = $monthTextual[$value] ?? '';
                    }

                    $row[] = $value;

                } elseif ($field === 'lastLocalisation' && isset($multipleLastLocalisation[$artwork->getId()])) {
                    $row[] = $multipleLastLocalisation[$artwork->getId()]; // Add the last localisation if the field is not found
                } else {
                    $row[] = ''; // Add an empty value if the field is not found
                }

            }
            $csvData[] = $row;
        }

        return $this->arrayToCsv($csvData);
    }

    /**
     * Convert array to a CSV string with a semicolon as a delimiter.
     *
     * @param array $rows
     * @return string
     */
    public function arrayToCsv(array $rows): string
    {
        $csv = '';
        foreach ($rows as $row) {
            $csv .= implode(';', $row)."\n";
        }

        return $csv;
    }
}
