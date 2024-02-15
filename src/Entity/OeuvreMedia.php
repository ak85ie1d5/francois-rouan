<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\{Entity, Column, Id, GeneratedValue};

#[Entity]
class OeuvreMedia
{
    #[Id]
    #[GeneratedValue]
    #[Column]
    private ?int $id = null;

    #[Column(length: 255, nullable: true)]
    private ?string $libelle = null;

    #[Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[Column]
    private ?int $position = null;

    #[Column]
    private ?int $createur = null;

    #[Column(nullable: true)]
    private ?int $modificateur = null;

    #[Column]
    private ?string $dateCreation = null;

    #[Column(length: 255, nullable: true)]
    private ?string $dateModification = null;

    #[Column(length: 255)]
    private ?string $nom = null;

    #[Column(length: 255)]
    private ?string $emplacement = null;

    #[Column(length: 10)]
    private ?string $extension = null;

    #[Column(length: 15)]
    private ?string $mime = null;

    #[Column]
    private ?int $taille = null;

}
