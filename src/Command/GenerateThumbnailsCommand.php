<?php
// src/Command/GenerateThumbnailsCommand.php

namespace App\Command;

use App\Entity\OeuvreMediaTest;
use App\Service\ThumbnailListener;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Vich\UploaderBundle\Mapping\PropertyMappingFactory;
use Vich\UploaderBundle\Event\Event;

class GenerateThumbnailsCommand extends Command
{
    protected static $defaultName = 'app:generate-thumbnails';

    private $entityManager;
    private $thumbnailListener;
    private $propertyMappingFactory;

    public function __construct(EntityManagerInterface $entityManager, ThumbnailListener $thumbnailListener, PropertyMappingFactory $propertyMappingFactory)
    {
        $this->entityManager = $entityManager;
        $this->thumbnailListener = $thumbnailListener;
        $this->propertyMappingFactory = $propertyMappingFactory;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Generates thumbnails for all existing images.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entities = $this->entityManager->getRepository(OeuvreMediaTest::class)->findAll();

        foreach ($entities as $entity) {
            $mapping = $this->propertyMappingFactory->fromField($entity, 'imageFile');

            $this->thumbnailListener->onPostUpload(new Event($entity, $mapping));

            // Get the file name and print it to the terminal
            $output->writeln($entity->getNom());
        }

        $output->writeln('Thumbnails generated successfully.');

        return Command::SUCCESS;
    }
}