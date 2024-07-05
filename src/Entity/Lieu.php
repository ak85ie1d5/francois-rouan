<?php

namespace App\Entity;

use App\Entity\Trait\TimeColumnTrait;
use App\Entity\Trait\UserColumnTrait;
use App\Repository\LieuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: LieuRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Lieu
{
    use UserColumnTrait, TimeColumnTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tel1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tel2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tel3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pays = null;

    #[ORM\OneToMany(mappedBy: 'lieu', targetEntity: OeuvreExposition::class)]
    private Collection $oeuvreExpositions;

    #[ORM\OneToMany(mappedBy: 'lieu', targetEntity: OeuvreStockage::class, cascade: ["persist"])]
    private Collection $oeuvreStockages;

    public function __construct()
    {
        $this->oeuvreExpositions = new ArrayCollection();
        $this->oeuvreStockages = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getTel1(): ?string
    {
        return $this->tel1;
    }

    public function setTel1(?string $tel1): static
    {
        $this->tel1 = $tel1;

        return $this;
    }

    public function getTel2(): ?string
    {
        return $this->tel2;
    }

    public function setTel2(?string $tel2): static
    {
        $this->tel2 = $tel2;

        return $this;
    }

    public function getTel3(): ?string
    {
        return $this->tel3;
    }

    public function setTel3(?string $tel3): static
    {
        $this->tel3 = $tel3;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

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

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): static
    {
        $this->pays = $pays;

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
            $oeuvreExposition->setLieu($this);
        }

        return $this;
    }

    public function removeOeuvreExposition(OeuvreExposition $oeuvreExposition): static
    {
        if ($this->oeuvreExpositions->removeElement($oeuvreExposition)) {
            // set the owning side to null (unless already changed)
            if ($oeuvreExposition->getLieu() === $this) {
                $oeuvreExposition->setLieu(null);
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
            $oeuvreStockage->setLieu($this);
        }

        return $this;
    }

    public function removeOeuvreStockage(OeuvreStockage $oeuvreStockage): static
    {
        if ($this->oeuvreStockages->removeElement($oeuvreStockage)) {
            // set the owning side to null (unless already changed)
            if ($oeuvreStockage->getLieu() === $this) {
                $oeuvreStockage->setLieu(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}
