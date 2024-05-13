<?php

namespace App\Entity;

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
    use TimeColumnTrait, UserColumnTrait;
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dimensions = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentairePublic = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $details = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaireInterne = null;

    #[ORM\OneToMany(mappedBy: 'oeuvre', targetEntity: OeuvreBibliographie::class, cascade: ["persist", "remove"], orphanRemoval: true)]
    private Collection $oeuvreBibliographies;

    #[ORM\OneToMany(mappedBy: 'oeuvre', targetEntity: OeuvreExposition::class, cascade: ["persist"])]
    private Collection $oeuvreExpositions;

    #[ORM\OneToMany(mappedBy: 'oeuvre', targetEntity: OeuvreStockage::class, cascade: ["persist"])]
    private Collection $oeuvreStockages;

    #[ORM\OneToMany(mappedBy: 'oeuvre', targetEntity: OeuvreHistorique::class, cascade: ["persist"])]
    private Collection $oeuvreHistoriques;

    #[ORM\OneToMany(mappedBy: 'oeuvre', targetEntity: OeuvreMediaTest::class, cascade: ["persist", "remove"], orphanRemoval: true)]
    #[ORM\OrderBy(["position" => "ASC"])]
    private Collection $mediaTest;

    #[ORM\ManyToOne(inversedBy: 'oeuvres')]
    #[ORM\JoinColumn(nullable: true)]
    private ?ArtworkCategory $ArtworkCategory = null;

    private ?array $primaryMedia;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $FirstDay = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $FirstMonth = null;

    #[ORM\Column(type: Types::INTEGER)]
    private int $FirstYear;
    #[ORM\Column]
    private ?bool $FirstDateUncertain = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $SecondDay = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $SecondMonth = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $SecondYear = null;
    #[ORM\Column]
    private ?bool $SecondDateUncertain = null;

    public function __construct(StorageInterface $storage)
    {
        $this->oeuvreBibliographies = new ArrayCollection();
        $this->oeuvreExpositions = new ArrayCollection();
        $this->oeuvreStockages = new ArrayCollection();
        $this->oeuvreHistoriques = new ArrayCollection();
        $this->mediaTest = new ArrayCollection();
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

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): static
    {
        $this->details = $details;

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
     * @return Collection<int, OeuvreMediaTest>
     */
    public function getMediaTest(): Collection
    {
        return $this->mediaTest;
    }

    public function addMediaTest(OeuvreMediaTest $mediaTest): static
    {
        if (!$this->mediaTest->contains($mediaTest)) {
            $this->mediaTest->add($mediaTest);
            $mediaTest->setOeuvre($this);
        }

        return $this;
    }

    public function removeMediaTest(OeuvreMediaTest $mediaTest): static
    {
        if ($this->mediaTest->removeElement($mediaTest)) {
            // set the owning side to null (unless already changed)
            if ($mediaTest->getOeuvre() === $this) {
                $mediaTest->setOeuvre(null);
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
        if ($this->getMediaTest()->first()) {
            return [$this->getMediaTest()->first()];
        }

        return null;
    }

    public function setPrimaryMedia($primaryMedia): static
    {
        $this->primaryMedia = $primaryMedia;

        return $this;
    }

    public function getFirstDay(): ?int
    {
        return $this->FirstDay;
    }

    public function setFirstDay(?int $FirstDay): static
    {
        $this->FirstDay = $FirstDay;

        return $this;
    }

    public function getFirstMonth(): ?int
    {
        return $this->FirstMonth;
    }

    public function setFirstMonth(?int $FirstMonth): static
    {
        $this->FirstMonth = $FirstMonth;

        return $this;
    }

    public function getFirstYear(): int
    {
        return $this->FirstYear;
    }

    public function setFirstYear(int $Firstyear): static
    {
        $this->FirstYear = $Firstyear;

        return $this;
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

    public function getSecondDay(): ?int
    {
        return $this->SecondDay;
    }

    public function setSecondDay(?int $SecondDay): static
    {
        $this->SecondDay = $SecondDay;

        return $this;
    }

    public function getSecondMonth(): ?int
    {
        return $this->SecondMonth;
    }

    public function setSecondMonth(?int $SecondMonth): static
    {
        $this->SecondMonth = $SecondMonth;

        return $this;
    }

    public function getSecondYear(): int
    {
        return $this->SecondYear;
    }

    public function setSecondYear(int $Secondyear): static
    {
        $this->SecondYear = $Secondyear;

        return $this;
    }

    public function getSecondDate(): ?\DateTime
    {
        if ($this->SecondYear && $this->SecondMonth && $this->SecondDay) {
            return new \DateTime(sprintf('%d-%d-%d', $this->SecondYear, $this->SecondMonth, $this->SecondDay));
        }

        return null;
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
}
