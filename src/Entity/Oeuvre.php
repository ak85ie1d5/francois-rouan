<?php

namespace App\Entity;

use App\Repository\OeuvreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OeuvreRepository::class)]
class Oeuvre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numInventaire = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sousTitre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $serie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dateComplement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dimensions = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentairePublic = null;

    #[ORM\Column(nullable: true)]
    private ?int $sousCategorie = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $details = null;

    #[ORM\Column]
    private ?int $nbMedias = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateModification = null;

    #[ORM\Column]
    private array $createur = [];

    #[ORM\Column]
    private array $modificateur = [];

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaireInterne = null;

    #[ORM\ManyToOne(inversedBy: 'oeuvres')]
    private ?OeuvreCategorie $categorie = null;

    #[ORM\OneToMany(mappedBy: 'oeuvre', targetEntity: OeuvreBibliographie::class)]
    private Collection $oeuvreBibliographies;

    #[ORM\OneToMany(mappedBy: 'oeuvre', targetEntity: OeuvreExposition::class)]
    private Collection $oeuvreExpositions;

    #[ORM\OneToMany(mappedBy: 'oeuvre', targetEntity: OeuvreStockage::class)]
    private Collection $oeuvreStockages;

    #[ORM\OneToMany(mappedBy: 'oeuvre', targetEntity: OeuvreHistorique::class)]
    private Collection $oeuvreHistoriques;

    #[ORM\Column(name: 'media', type: Types::JSON, nullable: true)]
    private ?array $media;

    public function __construct()
    {
        $this->oeuvreBibliographies = new ArrayCollection();
        $this->oeuvreExpositions = new ArrayCollection();
        $this->oeuvreStockages = new ArrayCollection();
        $this->oeuvreHistoriques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumInventaire(): ?string
    {
        return $this->numInventaire;
    }

    public function setNumInventaire(?string $numInventaire): static
    {
        $this->numInventaire = $numInventaire;

        return $this;
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

    public function getSousTitre(): ?string
    {
        return $this->sousTitre;
    }

    public function setSousTitre(?string $sousTitre): static
    {
        $this->sousTitre = $sousTitre;

        return $this;
    }

    public function getSerie(): ?string
    {
        return $this->serie;
    }

    public function setSerie(?string $serie): static
    {
        $this->serie = $serie;

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

    public function getDateComplement(): ?string
    {
        return $this->dateComplement;
    }

    public function setDateComplement(?string $dateComplement): static
    {
        $this->dateComplement = $dateComplement;

        return $this;
    }

    public function getDimensions(): ?string
    {
        return $this->dimensions;
    }

    public function setDimensions(?string $dimensions): static
    {
        $this->dimensions = $dimensions;

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

    public function getCommentairePublic(): ?string
    {
        return $this->commentairePublic;
    }

    public function setCommentairePublic(?string $commentairePublic): static
    {
        $this->commentairePublic = $commentairePublic;

        return $this;
    }

    public function getSousCategorie(): ?int
    {
        return $this->sousCategorie;
    }

    public function setSousCategorie(?int $sousCategorie): static
    {
        $this->sousCategorie = $sousCategorie;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getNbMedias(): ?int
    {
        return $this->nbMedias;
    }

    public function setNbMedias(int $nbMedias): static
    {
        $this->nbMedias = $nbMedias;

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

    public function getCommentaireInterne(): ?string
    {
        return $this->commentaireInterne;
    }

    public function setCommentaireInterne(?string $commentaireInterne): static
    {
        $this->commentaireInterne = $commentaireInterne;

        return $this;
    }

    public function getCategorie(): ?OeuvreCategorie
    {
        return $this->categorie;
    }

    public function setCategorie(?OeuvreCategorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, OeuvreBibliographie>
     */
    public function getOeuvreBibliographies(): Collection
    {
        return $this->oeuvreBibliographies;
    }

    public function addOeuvreBibliography(OeuvreBibliographie $oeuvreBibliography): static
    {
        if (!$this->oeuvreBibliographies->contains($oeuvreBibliography)) {
            $this->oeuvreBibliographies->add($oeuvreBibliography);
            $oeuvreBibliography->setOeuvre($this);
        }

        return $this;
    }

    public function removeOeuvreBibliography(OeuvreBibliographie $oeuvreBibliography): static
    {
        if ($this->oeuvreBibliographies->removeElement($oeuvreBibliography)) {
            // set the owning side to null (unless already changed)
            if ($oeuvreBibliography->getOeuvre() === $this) {
                $oeuvreBibliography->setOeuvre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OeuvreExposition>
     */
    public function getOeuvreExpositions(): Collection
    {
        return $this->oeuvreExpositions;
    }

    public function addOeuvreExposition(OeuvreExposition $oeuvreExposition): static
    {
        if (!$this->oeuvreExpositions->contains($oeuvreExposition)) {
            $this->oeuvreExpositions->add($oeuvreExposition);
            $oeuvreExposition->setOeuvre($this);
        }

        return $this;
    }

    public function removeOeuvreExposition(OeuvreExposition $oeuvreExposition): static
    {
        if ($this->oeuvreExpositions->removeElement($oeuvreExposition)) {
            // set the owning side to null (unless already changed)
            if ($oeuvreExposition->getOeuvre() === $this) {
                $oeuvreExposition->setOeuvre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OeuvreStockage>
     */
    public function getOeuvreStockages(): Collection
    {
        return $this->oeuvreStockages;
    }

    public function addOeuvreStockage(OeuvreStockage $oeuvreStockage): static
    {
        if (!$this->oeuvreStockages->contains($oeuvreStockage)) {
            $this->oeuvreStockages->add($oeuvreStockage);
            $oeuvreStockage->setOeuvre($this);
        }

        return $this;
    }

    public function removeOeuvreStockage(OeuvreStockage $oeuvreStockage): static
    {
        if ($this->oeuvreStockages->removeElement($oeuvreStockage)) {
            // set the owning side to null (unless already changed)
            if ($oeuvreStockage->getOeuvre() === $this) {
                $oeuvreStockage->setOeuvre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OeuvreHistorique>
     */
    public function getOeuvreHistoriques(): Collection
    {
        return $this->oeuvreHistoriques;
    }

    public function addOeuvreHistorique(OeuvreHistorique $oeuvreHistorique): static
    {
        if (!$this->oeuvreHistoriques->contains($oeuvreHistorique)) {
            $this->oeuvreHistoriques->add($oeuvreHistorique);
            $oeuvreHistorique->setOeuvre($this);
        }

        return $this;
    }

    public function removeOeuvreHistorique(OeuvreHistorique $oeuvreHistorique): static
    {
        if ($this->oeuvreHistoriques->removeElement($oeuvreHistorique)) {
            // set the owning side to null (unless already changed)
            if ($oeuvreHistorique->getOeuvre() === $this) {
                $oeuvreHistorique->setOeuvre(null);
            }
        }

        return $this;
    }

    public function getMedia(): ?array
    {
        return $this->media;
    }

    public function setMedia(?array $media): static
    {
        $this->media = $media;

        return $this;
    }
}
