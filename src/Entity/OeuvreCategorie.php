<?php

namespace App\Entity;

use App\Repository\OeuvreCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OeuvreCategorieRepository::class)]
class OeuvreCategorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(type: 'json_document')]
    private $sousCategories = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateModification = null;

    #[ORM\Column]
    private array $createur = [];

    #[ORM\Column]
    private array $modificateur = [];

    #[ORM\OneToMany(mappedBy: 'categorieId', targetEntity: Oeuvre::class)]
    private Collection $oeuvres;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: GroupeOeuvreCategoriePerm::class)]
    private Collection $groupeOeuvreCategoriePerms;

    public function __construct()
    {
        $this->oeuvres = new ArrayCollection();
        $this->groupeOeuvreCategoriePerms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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

    public function getSousCategories()
    {
        return $this->sousCategories;
    }

    public function setSousCategories($sousCategories): static
    {
        $this->sousCategories = $sousCategories;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }

    public function setDateModification(?\DateTimeInterface $dateModification): static
    {
        $this->dateModification = $dateModification;

        return $this;
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

    /**
     * @return Collection<int, Oeuvre>
     */
    public function getOeuvres(): Collection
    {
        return $this->oeuvres;
    }

    public function addOeuvre(Oeuvre $oeuvre): static
    {
        if (!$this->oeuvres->contains($oeuvre)) {
            $this->oeuvres->add($oeuvre);
            $oeuvre->setCategorieId($this);
        }

        return $this;
    }

    public function removeOeuvre(Oeuvre $oeuvre): static
    {
        if ($this->oeuvres->removeElement($oeuvre)) {
            // set the owning side to null (unless already changed)
            if ($oeuvre->getCategorieId() === $this) {
                $oeuvre->setCategorieId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GroupeOeuvreCategoriePerm>
     */
    public function getGroupeOeuvreCategoriePerms(): Collection
    {
        return $this->groupeOeuvreCategoriePerms;
    }

    public function addGroupeOeuvreCategoriePerm(GroupeOeuvreCategoriePerm $groupeOeuvreCategoriePerm): static
    {
        if (!$this->groupeOeuvreCategoriePerms->contains($groupeOeuvreCategoriePerm)) {
            $this->groupeOeuvreCategoriePerms->add($groupeOeuvreCategoriePerm);
            $groupeOeuvreCategoriePerm->setCategorie($this);
        }

        return $this;
    }

    public function removeGroupeOeuvreCategoriePerm(GroupeOeuvreCategoriePerm $groupeOeuvreCategoriePerm): static
    {
        if ($this->groupeOeuvreCategoriePerms->removeElement($groupeOeuvreCategoriePerm)) {
            // set the owning side to null (unless already changed)
            if ($groupeOeuvreCategoriePerm->getCategorie() === $this) {
                $groupeOeuvreCategoriePerm->setCategorie(null);
            }
        }

        return $this;
    }
}
