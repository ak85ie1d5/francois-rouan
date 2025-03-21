<?php

namespace App\Entity;

use App\Entity\Trait\FirstDateTrait;
use App\Entity\Trait\SecondDateTrait;
use App\Entity\Trait\TimeColumnTrait;
use App\Entity\Trait\UserColumnTrait;
use App\Repository\OeuvreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Storage\StorageInterface;

#[ORM\Entity(repositoryClass: OeuvreRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Oeuvre
{
    use TimeColumnTrait, UserColumnTrait, FirstDateTrait, SecondDateTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numInventaire = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sousTitre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $serie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dimensions = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentairePublic = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaireInterne = null;

    #[ORM\OneToMany(mappedBy: 'oeuvre', targetEntity: OeuvreBibliographie::class, cascade: ["persist", "remove"], orphanRemoval: true)]
    #[ORM\OrderBy(["Year" => "DESC"])]
    private Collection $oeuvreBibliographies;

    #[ORM\OneToMany(mappedBy: 'oeuvre', targetEntity: OeuvreExposition::class, cascade: ["persist", "remove"], orphanRemoval: true)]
    #[ORM\OrderBy(["FirstYear" => "DESC"])]
    private Collection $oeuvreExpositions;

    #[ORM\OneToMany(mappedBy: 'oeuvre', targetEntity: OeuvreStockage::class, cascade: ["persist", "remove"], orphanRemoval: true)]
    private Collection $oeuvreStockages;

    #[ORM\OneToMany(mappedBy: 'oeuvre', targetEntity: OeuvreHistorique::class, cascade: ["persist", "remove"], orphanRemoval: true)]
    private Collection $oeuvreHistoriques;

    #[ORM\OneToMany(mappedBy: 'oeuvre', targetEntity: ArtworkMedia::class, cascade: ["persist", "remove"], orphanRemoval: true)]
    #[ORM\OrderBy(["position" => "ASC"])]
    private Collection $ArtworkMedias;

    #[ORM\ManyToOne(inversedBy: 'oeuvres')]
    #[ORM\JoinColumn(nullable: true)]
    private ?ArtworkCategory $ArtworkCategory = null;

    private ?array $primaryMedia;

    #[ORM\Column]
    private ?bool $FirstDateUncertain = null;

    #[ORM\Column]
    private ?bool $SecondDateUncertain = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $dateSeparator = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dateComplement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $DimensionWithFrame = null;

    public function __construct(StorageInterface $storage)
    {
        $this->oeuvreBibliographies = new ArrayCollection();
        $this->oeuvreExpositions = new ArrayCollection();
        $this->oeuvreStockages = new ArrayCollection();
        $this->oeuvreHistoriques = new ArrayCollection();
        $this->ArtworkMedias = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumInventaire(): ?string
    {
        return $this->numInventaire;
    }

    public function setNumInventaire(string $numInventaire): static
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

    public function getCommentaireInterne(): ?string
    {
        return $this->commentaireInterne;
    }

    public function setCommentaireInterne(?string $commentaireInterne): static
    {
        $this->commentaireInterne = $commentaireInterne;

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

    /**
     * @return Collection<int, ArtworkMedia>
     */
    public function getArtworkMedias(): Collection
    {
        return $this->ArtworkMedias;
    }

    public function addArtworkMedia(ArtworkMedia $ArtworkMedia): static
    {
        if (!$this->ArtworkMedias->contains($ArtworkMedia)) {
            $this->ArtworkMedias->add($ArtworkMedia);
            $ArtworkMedia->setOeuvre($this);
        }

        return $this;
    }

    public function removeArtworkMedia(ArtworkMedia $ArtworkMedia): static
    {
        if ($this->ArtworkMedias->removeElement($ArtworkMedia)) {
            // set the owning side to null (unless already changed)
            if ($ArtworkMedia->getOeuvre() === $this) {
                $ArtworkMedia->setOeuvre(null);
            }
        }

        return $this;
    }

    public function getArtworkCategory(): ?ArtworkCategory
    {
        return $this->ArtworkCategory;
    }

    public function setArtworkCategory(?ArtworkCategory $ArtworkCategory): static
    {
        $this->ArtworkCategory = $ArtworkCategory;

        return $this;
    }

    public function getPrimaryMedia(): ?array
    {
        if ($this->getArtworkMedias()->first()) {
            return [$this->getArtworkMedias()->first()];
        }

        return null;
    }

    public function setPrimaryMedia($primaryMedia): static
    {
        $this->primaryMedia = $primaryMedia;

        return $this;
    }

    public function getFirstYearAlt(): string
    {
        if ($this->isFirstDateUncertain()) {
            return $this->getFirstYear().' ?';
        }

        if ($this->getFirstYear() === 0) {
            return '';
        }

        return $this->getFirstYear();
    }

    public function isFirstDateUncertain(): ?bool
    {
        return $this->FirstDateUncertain;
    }

    public function setFirstDateUncertain(bool $FirstDateUncertain): static
    {
        $this->FirstDateUncertain = $FirstDateUncertain;

        return $this;
    }

    public function isSecondDateUncertain(): ?bool
    {
        return $this->SecondDateUncertain;
    }

    public function setSecondDateUncertain(bool $SecondDateUncertain): static
    {
        $this->SecondDateUncertain = $SecondDateUncertain;

        return $this;
    }


    public function __toString(): string
    {
        return "N° inv $this->numInventaire - $this->titre";
    }

    public function getDateSeparator(): ?int
    {
        return $this->dateSeparator;
    }

    public function setDateSeparator(?int $dateSeparator): static
    {
        $this->dateSeparator = $dateSeparator;

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

    public function getDimensionWithFrame(): ?string
    {
        return $this->DimensionWithFrame;
    }

    public function setDimensionWithFrame(?string $DimensionWithFrame): static
    {
        $this->DimensionWithFrame = $DimensionWithFrame;

        return $this;
    }
}
