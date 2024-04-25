<?php

namespace App\DataFixtures;

use App\Entity\Groupe;
use App\Service\ExternalDataService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupeFixtures extends Fixture
{
    private ExternalDataService $externalDataService;

    public function __construct(ExternalDataService $externalDataService)
    {
        $this->externalDataService = $externalDataService;
    }

    public function load(ObjectManager $manager): void
    {
        $externalGroups = $this->externalDataService->getExternalGroups();

        foreach ($externalGroups as $externalGroup) {
            $groupe = new Groupe();

            $groupe->setNom($externalGroup['nom'])
                ->setDescription($externalGroup['description'])
                ->setCommentaire($externalGroup['commentaire'])
                ->setCreateur(json_decode($externalGroup['createur'],true))
                ->setDateCreation(new \DateTime($externalGroup['date_creation']));

            $manager->persist($groupe);
        }

        $manager->flush();
    }
}
