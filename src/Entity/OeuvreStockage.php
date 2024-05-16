<?php

namespace App\Entity;

use App\Entity\Trait\UserColumnTrait;
use App\Repository\OeuvreStockageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OeuvreStockageRepository::class)]
#[ORM\HasLifecycleCallbacks]
class OeuvreStockage
{
    use Trait\FirstDateTrait;
    use Trait\TimeColumnTrait;
    use Trait\UserColumnTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $precisions = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $type = null;

    #[ORM\ManyToOne(inversedBy: 'oeuvreStockages')]
    private ?Oeuvre $oeuvre = null;

    #[ORM\ManyToOne(inversedBy: 'oeuvreStockages')]
    private ?Lieu $lieu = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrecisions(): ?int
    {
        return $this->precisions;
    }

    public function setPrecisions(?int $precisions): static
    {
        $this->precisions = $precisions;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): static
    {
        $this->type = $type;

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

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function __toString(): string
    {
        return <<<END
            {$this->getLieu()->getNom()}
            {$this->getLieu()->getVille()}
            {$this->getLieu()->getPays()}
            END;
    }
}
