<?php

namespace App\Entity;

use App\Repository\OeuvreBibliographieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OeuvreBibliographieRepository::class)]
#[ORM\HasLifecycleCallbacks]
class OeuvreBibliographie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateModification = null;

    #[ORM\Column]
    private array $createur = [];

    #[ORM\Column]
    private array $modificateur = [];

    #[ORM\ManyToOne(inversedBy: 'oeuvreBibliographies')]
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    #[ORM\PrePersist]
    public function setDateCreation(): void
    {
        $this->dateCreation = new \DateTime();
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }

    #[ORM\PreUpdate]
    public function setDateModification(): void
    {
        $this->dateModification = new \DateTime();
    }

    public function getCreateur(): array
    {
        return $this->createur;
    }

    public function setCreateur(array $createur): static
    {
        $this->createur = $createur;

        return $this;
    }

    public function getModificateur(): array
    {
        return $this->modificateur;
    }

    public function setModificateur(array $modificateur): static
    {
        $this->modificateur = $modificateur;

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
