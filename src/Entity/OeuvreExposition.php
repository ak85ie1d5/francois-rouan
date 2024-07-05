<?php

namespace App\Entity;

use App\Entity\Trait\FirstDateTrait;
use App\Entity\Trait\SecondDateTrait;
use App\Entity\Trait\TimeColumnTrait;
use App\Entity\Trait\UserColumnTrait;
use App\Repository\OeuvreExpositionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OeuvreExpositionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class OeuvreExposition
{
    use TimeColumnTrait, UserColumnTrait, FirstDateTrait, SecondDateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\ManyToOne(inversedBy: 'oeuvreExpositions')]
    private ?Lieu $lieu = null;

    #[ORM\ManyToOne(inversedBy: 'oeuvreExpositions')]
    private ?Oeuvre $oeuvre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getOeuvre(): ?Oeuvre
    {
        return $this->oeuvre;
    }

    public function setOeuvre(?Oeuvre $oeuvre): static
    {
        $this->oeuvre = $oeuvre;

        return $this;
    }

    public function __toString(): string
    {
        return $this->titre;
    }
}
