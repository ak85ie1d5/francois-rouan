<?php

namespace App\Service;


use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Service to generate PDF from HTML template
 *
 * @package App\Service
 */
class PdfExportService
{
    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * PdfExportService constructor.
     *
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Generate PDF from HTML template
     *
     * @param string $id
     * @param array $fields
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function generatePdf(string $id, array $fields): Response
    {
        $filename = $fields['oeuvre']->getNumInventaire().' - '.$fields['oeuvre']->getTitre();
        // Render HTML template
        $html = $this->twig->render('pdf/oeuvre.html.twig', $fields);

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled', true);

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        // Stream the PDF to the browser
        $dompdf->stream($filename, ["Attachment" => false]);

        return new Response('', Response::HTTP_OK, ['Content-Type' => 'application/pdf']);
    }

    /**
     * Convert image to base64
     *
     * @param string $imagePath
     * @return string
     */
    public function convertImageToBase64(string $imagePath): string
    {
        $type = pathinfo($imagePath, PATHINFO_EXTENSION);
        $data = file_get_contents($imagePath);

        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}