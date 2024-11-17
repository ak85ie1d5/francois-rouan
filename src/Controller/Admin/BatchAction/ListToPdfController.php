<?php

namespace App\Controller\Admin\BatchAction;

use App\Controller\PDF\OeuvreController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListToPdfController extends AbstractController
{
    private OeuvreController $oeuvreController;

    public function __construct(OeuvreController $oeuvreController)
    {
        $this->oeuvreController = $oeuvreController;
    }

    #[Route('/list/to/pdf', name: 'app_list_to_pdf')]
    public function index(Request $request, BatchActionDto $batchActionDto): Response
    {
        $ids = $batchActionDto->getEntityIds();


        foreach ($ids as $id) {
            $this->oeuvreController->index($id);
        }
    }
}
