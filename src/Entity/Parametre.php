<?php

namespace App\Entity;

use App\Repository\ParametreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParametreRepository::class)]
class Parametre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $espaceUtilise = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEspaceUtilise(): ?string
    {
        return $this->espaceUtilise;
    }

    public function setEspaceUtilise(string $espaceUtilise): static
    {
        $this->espaceUtilise = $espaceUtilise;

        return $this;
    }
}
