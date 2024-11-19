<?php

namespace App\Controller\PDF;


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
     * @return string
     */
    #[Route('/pdf/oeuvre/{id}', name: 'pdf_oeuvre')]
    public function index(int $id): string
    {
        $fields = $this->pdfExportService->getPdfContent($id);

        return $this->pdfExportService->generatePdf($fields, true);
    }
}
