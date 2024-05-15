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

        // Render HTML template
        $html = $this->renderView('pdf/oeuvre.html.twig', [
            'oeuvre' => $oeuvresData
        ]);

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled', true);
        $pdfOptions->set('chroot', realpath(''));

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        $dompdf->stream();

    }
}