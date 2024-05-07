<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use App\Entity\Oeuvre;
use App\Entity\OeuvreStockage;
use App\Entity\Utilisateur;
use App\Service\ExternalDataService;
use App\Utils\DateChoices;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use ReflectionObject;

class StockageFixtures extends Fixture
{
    private ExternalDataService $externalDataService;

    public function __construct(ExternalDataService $externalDataService)
    {
        $this->externalDataService = $externalDataService;
    }

    public function load(ObjectManager $manager): void
    {
        $sql = "SELECT `id`, `oeuvre_id`, `lieu_id`, `date_debut`, `description`, `commentaire`, `date_creation`, `date_modification`, `createur`, `modificateur`, `precisions`, `type` FROM `oeuvre_stockage`;";

        $externalData = $this->externalDataService->getExternalDatas($sql);

        foreach ($externalData as $externalStockage) {
            $entity = new OeuvreStockage();

            // Get the id property
            $reflectionObject = new ReflectionObject($entity);
            $idProperty = $reflectionObject->getProperty('id');
            $idProperty->setAccessible(true);
            $idProperty->setValue($entity, $externalStockage['id']);

            // Get the lieu_id property
            $lieu_id = $manager->getReference(Lieu::class, $externalStockage['lieu_id']);
            $entity->setLieu($lieu_id);

            // Get the oeuvre_id property
            $euvre_id = $manager->getReference(Oeuvre::class, $externalStockage['oeuvre_id']);
            $entity->setOeuvre($euvre_id);

            // Get the date_debut property
            $dateDebut = new \DateTime($externalStockage['date_debut']);
            $entity->setDay((int)$dateDebut->format('d'));
            $entity->setMonth((int)$dateDebut->format('m'));
            $entity->setYear((int)$dateDebut->format('Y'));

            // Get the description property
            $entity->setDescription($externalStockage['description']);
            // Get the commentaire property
            $entity->setCommentaire($externalStockage['commentaire']);
            
            $dataChoices = new DateChoices();
            // Get the type property
            if ($externalStockage['type'] && array_key_exists($externalStockage['type'], $dataChoices->getLocalisationTypes())) {
                $entity->setType($dataChoices->getLocalisationTypes()[$externalStockage['type']]);
            } else {
                $entity->setType(0);
            }

            // Get the precisions property
            if ($externalStockage['precisions'] && array_key_exists($externalStockage['precisions'], $dataChoices->getLocalisationDetails())) {
                $entity->setPrecisions($dataChoices->getLocalisationDetails()[$externalStockage['precisions']]);
            } else {
                $entity->setPrecisions(0);
            }

            // Get the date_creation properties
            $entity->setOldCreatedAt(new \DateTime($externalStockage['date_creation']));

            // Get the date_modification properties
            $entity->setOldUpdatedAt(new \DateTime($externalStockage['date_modification']));

            // Get the createur properties
            $jsonUserId = json_decode($externalStockage['createur'], true);
            $createdBy = $manager->getReference(Utilisateur::class, $jsonUserId);
            $entity->setCreatedBy($createdBy);

            // Get the modificateur properties
            $jsonUserId = json_decode($externalStockage['modificateur'], true);
            if ($jsonUserId) {
                $updatedBy = $manager->getReference(Utilisateur::class, $jsonUserId);
                $entity->setUpdatedBy($updatedBy);
            }

            $manager->persist($entity);
        }

        $manager->flush();
    }
}