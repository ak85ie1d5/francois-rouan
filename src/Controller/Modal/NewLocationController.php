<?php

namespace App\Controller\Modal;

use App\Entity\Lieu;
use App\Form\Type\LieuCollectionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewLocationController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    #[Route('/admin/new_location', name: 'app_admin_new_location')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lieu = new Lieu();
        $form = $this->createForm(LieuCollectionType::class, $lieu);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Set current user as creator
            $lieu->setCreatedBy($this->security->getUser());
            // Set current date as creation date
            $lieu->setCreatedAt(new \DateTime());

            $entityManager->persist($lieu);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_new_location');
        }

        return $this->render('admin/new_location/index.html.twig', [
            'form' => $form->createView(),
            'ea' => [
                'page_title' => 'Nouveau lieu',
                'page_header' => 'Nouveau lieu',
            ],
        ]);
    }
}
