<?php

namespace App\Service;


use App\Entity\Oeuvre;
use App\Entity\OeuvreBibliographie;
use App\Entity\OeuvreExposition;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Options as OptionsEntity;
use Symfony\Component\AssetMapper\AssetMapperInterface;
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

    private  AssetMapperInterface $assetMapper;

    /**
     * PdfExportService constructor.
     *
     * @param Environment $twig
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, Environment $twig, string $projectDir, AssetMapperInterface $assetMapper)
    {
        $this->entityManager = $entityManager;
        $this->twig = $twig;
        $this->projectDir = $projectDir;
        $this->assetMapper = $assetMapper;
    }

    /**
     * Generate PDF from HTML template
     *
     * @param array $fields
     * @param bool $isSingle
     * @param string $combinedHtml
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function generatePdf(array $fields, bool $isSingle, string $combinedHtml = ''): string
    {
        // Render HTML template
        $html = $isSingle ? $this->twig->render('pdf/oeuvre.html.twig', $fields) : $combinedHtml;

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

        return $dompdf->output();
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

        // Convert the primary media image to base64, or use a dummy image if not available
        if (isset($oeuvresData->getPrimaryMedia()[0])) {
            $base64Image = $this->convertImageToBase64($oeuvresData->getPrimaryMedia()[0]->getImageFile());
            $primaryMedia = [
                'photoCredit' => $oeuvresData->getPrimaryMedia()[0]->getPhotoCredit(),
                'photographerName' => $oeuvresData->getPrimaryMedia()[0]->getPhotographerName()
            ];
        } else {
            $asset = $this->assetMapper->getAsset('img/dummy-image-square.jpg');
            $base64Image = $this->convertImageToBase64($this->projectDir . '/public' . $asset->publicPath);
            $primaryMedia = null;
        }

        // Retrieve additional options for the PDF
        $monthTextual = $this->entityManager->getRepository(OptionsEntity::class)->findOneBy(['name' => 'month_textual'])->getValue();
        $separator = $this->entityManager->getRepository(OptionsEntity::class)->findOneBy(['name' => 'date_separator'])->getValue();

        // Prepare the fields for the PDF template
        return [
            'oeuvre' => $oeuvresData,
            'base64Image' => $base64Image,
            'primary_media' => $primaryMedia,
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

    /**
     * Retrieve the bibliography for the Oeuvre entity
     *
     * @param int $artworkId
     * @return OeuvreBibliographie[]
     */
    public function getBibliography(int $artworkId): array
    {
        return $this->entityManager->getRepository(OeuvreBibliographie::class)->findBy(['oeuvre' => $artworkId], ['Year' => 'DESC']);
    }

    /**
     * Retrieve the exhibition for the Oeuvre entity
     *
     * @param int $artworkId
     * @return OeuvreExposition[]
     */
    public function getExhibition(int $artworkId): array
    {
        return $this->entityManager->getRepository(OeuvreExposition::class)->findBy(['oeuvre' => $artworkId], ['FirstYear' => 'DESC']);
    }

    /**
     * Generate HTML from the fields
     *
     * @param array $fields
     * @return string
     */
    public function generateHtml(array $fields): string
    {
        return $this->twig->render('pdf/oeuvre.html.twig', $fields);
    }
}