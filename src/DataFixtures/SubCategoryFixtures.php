<?php

namespace App\DataFixtures;

use App\Entity\ArtworkCategory;
use App\Entity\Utilisateur;
use App\Service\ExternalDataService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubCategoryFixtures extends Fixture
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

        foreach ($externalCategories as $externalSubCategory) {

            $extSubCat = json_decode($externalSubCategory['sous_categories'], true);
            if ($extSubCat) {

                foreach ($extSubCat as $subCat) {

                    $category = new ArtworkCategory();

                    $parentCat = $manager->getReference(ArtworkCategory::class, $externalSubCategory['id']);
                    $category->setParent($parentCat);

                    $category->setName($subCat['nom']);

                    $createdBy = $manager->getReference(Utilisateur::class, $subCat['createur']);
                    $category->setCreatedBy($createdBy);

                    if ($subCat['modificateur']) {
                        $updatedBy = $manager->getReference(Utilisateur::class, $subCat['modificateur']);
                        $category->setUpdatedBy($updatedBy);
                    }
                    $category->setOldCreatedAt(new \DateTime($subCat['dateCreation']));
                    $category->setOldUpdatedAt(new \DateTime($subCat['dateModification']));

                    $manager->persist($category);
                }
            }
        }

        $manager->flush();
    }
}
