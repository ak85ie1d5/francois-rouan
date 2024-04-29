<?php

namespace App\DataFixtures;

use App\Entity\ArtworkCategory;
use App\Entity\Utilisateur;
use App\Service\ExternalDataService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    private ExternalDataService $externalDataService;

    public function __construct(ExternalDataService  $externalDataService)
    {
        $this->externalDataService = $externalDataService;
    }

    public function load(ObjectManager $manager): void
    {
        $sql = "SELECT `id`, `nom`, `sous_categories`, `date_creation`, `date_modification`, `createur`, `modificateur` FROM `oeuvre_categorie`";
        $externalCategories = $this->externalDataService->getExternalDatas($sql);

        foreach ($externalCategories as $externalCategory) {
            $category = new ArtworkCategory();

            $category->setName($externalCategory['nom']);
            $category->setOldCreatedAt(new \DateTime($externalCategory['date_creation']));
            $category->setOldUpdatedAt(new \DateTime($externalCategory['date_modification']));

            $jsonUserId = json_decode($externalCategory['createur'], true);
            $createdBy = $manager->getReference(Utilisateur::class, $jsonUserId);
            $category->setCreatedBy($createdBy);

            $jsonUserId = json_decode($externalCategory['modificateur'], true);
            if ($jsonUserId) {
                $updatedBy = $manager->getReference(Utilisateur::class, $jsonUserId);
                $category->setUpdatedBy($updatedBy);
            }

            $manager->persist($category);
        }

        $manager->flush();
    }
}
