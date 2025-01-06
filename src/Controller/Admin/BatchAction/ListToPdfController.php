<?php

namespace App\Controller\Admin\BatchAction;

use App\Service\PdfExportService;
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ListToPdfController extends AbstractController
{
    private PdfExportService $pdfExportService;

    public function __construct(PdfExportService $pdfExportService)
    {
        $this->pdfExportService = $pdfExportService;
    }

    /**
     * Route to generate a PDF for a list of Oeuvre entities.
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    #[Route('/list/to/zip', name: 'app_list_to_zip')]
    public function indexZip(Request $request, BatchActionDto $batchActionDto): Response
    {
        $ids = $batchActionDto->getEntityIds();
        $zip = new \ZipArchive();
        $zipFilename = 'export_oeuvres_' . date('Y-m-d_His') . '.zip';
        $tempDir = sys_get_temp_dir();

        if ($zip->open($tempDir . '/' . $zipFilename, \ZipArchive::CREATE) !== true) {
            return new Response('Cannot open the zip file', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        foreach ($ids as $id) {
            $fields = $this->pdfExportService->getPdfContent($id);

            if ($request->request->get('includeBibliography') === 'true') {
                $fields['bibliographies'] = $this->pdfExportService->getBibliography($id);
            }

            if ($request->request->get('includeExhibition') === 'true') {
                $fields['exhibitions'] = $this->pdfExportService->getExhibition($id);
            }

            $pdfContent = $this->pdfExportService->generatePdf($fields, false);
            $pdfFilename =$fields['oeuvre']->getNumInventaire().' - '.$fields['oeuvre']->getTitre().'.pdf';

            $zip->addFromString($pdfFilename, $pdfContent);
        }

        $zip->close();

        return $this->file($tempDir . '/' . $zipFilename);
    }

    /**
     * Route to generate a PDF for a list of Oeuvre entities.
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    #[Route('/list/to/pdf', name: 'app_list_to_pdf')]
    public function indexPdf(Request $request, BatchActionDto $batchActionDto): Response
    {
        $ids = $batchActionDto->getEntityIds();
        $htmlContent = '';

        foreach ($ids as $id) {
            $fields = $this->pdfExportService->getPdfContent($id);

            if ($request->request->get('includeBibliography') === 'true') {
                $fields['bibliographies'] = $this->pdfExportService->getBibliography($id);
            }

            if ($request->request->get('includeExhibition') === 'true') {
                $fields['exhibitions'] = $this->pdfExportService->getExhibition($id);
            }

            $htmlContent .= $this->pdfExportService->generateHtml($fields);
        }

        $pdfContent = $this->pdfExportService->generatePdf([], false, $htmlContent);

        return new Response($pdfContent, Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="export_oeuvres_' . date('Y-m-d_His') . '.pdf"',
        ]);
    }
}
