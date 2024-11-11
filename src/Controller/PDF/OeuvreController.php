<?php

namespace App\Controller\PDF;

use App\Entity\Oeuvre;
use App\Service\PdfExportService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controller for handling PDF export of Oeuvre entities.
 */
class OeuvreController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private PdfExportService $pdfExportService;

    /**
     * Constructor to initialize dependencies.
     *
     * @param EntityManagerInterface $entityManager
     * @param PdfExportService $pdfExportService
     */
    public function __construct(EntityManagerInterface $entityManager, PdfExportService $pdfExportService)
    {
        $this->pdfExportService = $pdfExportService;
        $this->entityManager = $entityManager;
    }

    /**
     * Route to generate a PDF for a specific Oeuvre entity.
     *
     * @param int $id The ID of the Oeuvre entity.
     *
     * @return void
     */
    #[Route('/pdf/oeuvre/{id}', name: 'pdf_oeuvre')]
    public function index(int $id): void
    {
        // Retrieve the Oeuvre entity by ID
        $oeuvresData = $this->entityManager->getRepository(Oeuvre::class)->findOneBy(['id' => $id]);

        // Retrieve the last localisation of the Oeuvre entity
        $lastLocalisation = $this->entityManager->getRepository(Oeuvre::class)->getLastLocalisation($id);

        // Convert the primary media image to base64, or use a dummy image if not available
        if (isset($oeuvresData->getPrimaryMedia()[0])) {
            $base64Image = $this->pdfExportService->convertImageToBase64($oeuvresData->getPrimaryMedia()[0]->getImageFile());
        } else {
            $base64Image = $this->pdfExportService->convertImageToBase64('../public/dummy-image-square.jpg');
        }

        // Retrieve additional options for the PDF
        $monthTextual = $this->entityManager->getRepository(\App\Entity\Options::class)->findOneBy(['name' => 'month_textual'])->getValue();
        $separator = $this->entityManager->getRepository(\App\Entity\Options::class)->findOneBy(['name' => 'date_separator'])->getValue();

        // Prepare the fields for the PDF template
        $fields = [
            'oeuvre' => $oeuvresData,
            'last_localisation' => $lastLocalisation,
            'base64Image' => $base64Image,
            'month_textual' => $monthTextual,
            'separator' => $separator
        ];

        // Generate the PDF using the PdfExportService
        $this->pdfExportService->generatePdf($id, $fields);
    }
}