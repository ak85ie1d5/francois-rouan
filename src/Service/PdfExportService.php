<?php

namespace App\Service;


use App\Entity\Oeuvre;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Options as OptionsEntity;
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
    private EntityManagerInterface $entityManager;

    /**
     * PdfExportService constructor.
     *
     * @param Environment $twig
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, Environment $twig)
    {
        $this->entityManager = $entityManager;
        $this->twig = $twig;
    }

    /**
     * Generate PDF from HTML template
     *
     * @param array $fields
     * @param bool $isSingle
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function generatePdf(array $fields, bool $isSingle): string
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

        if ($isSingle) {
            // Output the generated PDF to Browser (inline view)
            $dompdf->stream($filename, ["Attachment" => false]);
            return new Response('', Response::HTTP_OK, ['Content-Type' => 'application/pdf']);
        } else {
            // Output the generated PDF to a file
            return $dompdf->output();
        }
    }

    /**
     * Retrieve the Oeuvre entity from the database and prepare the fields for the PDF template
     *
     * @param int $id
     * @return array
     */
    public function getPdfContent(int $id) :array
    {
        // Retrieve the Oeuvre entity by ID
        $oeuvresData = $this->entityManager->getRepository(Oeuvre::class)->findOneBy(['id' => $id]);

        // Retrieve the last localisation of the Oeuvre entity
        $lastLocalisation = $this->entityManager->getRepository(Oeuvre::class)->getLastLocalisation($id);

        // Convert the primary media image to base64, or use a dummy image if not available
        if (isset($oeuvresData->getPrimaryMedia()[0])) {
            $base64Image = $this->convertImageToBase64($oeuvresData->getPrimaryMedia()[0]->getImageFile());
        } else {
            $base64Image = $this->convertImageToBase64('../public/dummy-image-square.jpg');
        }

        // Retrieve additional options for the PDF
        $monthTextual = $this->entityManager->getRepository(OptionsEntity::class)->findOneBy(['name' => 'month_textual'])->getValue();
        $separator = $this->entityManager->getRepository(OptionsEntity::class)->findOneBy(['name' => 'date_separator'])->getValue();

        // Prepare the fields for the PDF template
        return [
            'oeuvre' => $oeuvresData,
            'last_localisation' => $lastLocalisation,
            'base64Image' => $base64Image,
            'month_textual' => $monthTextual,
            'separator' => $separator
        ];
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