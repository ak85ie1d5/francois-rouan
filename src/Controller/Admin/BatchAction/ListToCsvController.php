<?php

namespace App\Controller\Admin\BatchAction;

use App\Service\CsvExportService;
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListToCsvController extends AbstractController
{
    private CsvExportService $csvExportService;

    public function __construct(CsvExportService $csvExportService)
    {
        $this->csvExportService = $csvExportService;
    }

    #[Route('/list/to/csv', name: 'app_list_to_csv')]
    public function index(Request $request, BatchActionDto $batchActionDto): Response
    {
        $ids = $batchActionDto->getEntityIds();

        $fields = ["numInventaire", "titre", "FirstMonth", "FirstYear", "SecondMonth", "SecondYear", "dimensions", "description", "commentairePublic", "lastLocalisation"];
        $csvContent = $this->csvExportService->generateCsv($ids, $fields);

        $filename = 'export_oeuvres_'.date('Y-m-d').'.csv';
        $response = new Response($csvContent);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');

        return $response;
    }
}
