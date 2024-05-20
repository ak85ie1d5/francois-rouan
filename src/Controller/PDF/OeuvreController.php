<?php

namespace App\Controller\PDF;

use App\Entity\Oeuvre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class OeuvreController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/pdf/oeuvre/{id}', name: 'pdf_oeuvre')]
    public function index($id): Response
    {
        // Fetch data from `oeuvre` entity
        // This is just a placeholder, replace with your actual data fetching logic
        $oeuvresData = $this->entityManager->getRepository(Oeuvre::class)->findOneBy(['id' => $id]);
        $lastLocalisation = $this->entityManager->getRepository(Oeuvre::class)->getLastLocalisation($id);
        if (isset($oeuvresData->getPrimaryMedia()[0])) {
            $base64Image = $this->convertImageToBase64($oeuvresData->getPrimaryMedia()[0]->getImageFile());
        } else {
            $base64Image = $this->convertImageToBase64('../public/dummy-image-square.jpg');
        }

        $filename = $oeuvresData->getNumInventaire().' - '.$oeuvresData->getTitre();

        // Render HTML template
        $html = $this->renderView('pdf/oeuvre.html.twig', [
            'oeuvre' => $oeuvresData,
            'last_localisation' => $lastLocalisation,
            'base64Image' => $base64Image
        ]);

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

        return new Response (
            $dompdf->stream($oeuvresData->getNumInventaire().' - '.$oeuvresData->getTitre(), ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    function convertImageToBase64($imagePath): string
    {
        $type = pathinfo($imagePath, PATHINFO_EXTENSION);
        $data = file_get_contents($imagePath);

        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}