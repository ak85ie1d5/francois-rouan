<?php

namespace App\Entity;

use App\Repository\ArtworkMediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ArtworkMediaRepository::class)]
#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
class ArtworkMedia
{
    use Trait\TimeColumnTrait, Trait\UserColumnTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $caption = null;

    #[ORM\Column]
    private ?int $position = 1;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $mime = null;

    #[ORM\Column(nullable: true)]
    private ?int $taille = null;

    #[ORM\ManyToOne(inversedBy: 'ArtworkMedias')]
    private ?Oeuvre $oeuvre = null;

    #[Vich\UploadableField(mapping: 'artworks', fileNameProperty: 'nom', size: 'taille', mimeType: 'mime', originalName: 'libelle')]
    private ?File $imageFile = null;

    private ?string $thumbnailName = null;

    #[Vich\UploadableField(mapping: 'artworks', fileNameProperty: 'thumbnailName')]
    private ?File $thumbnailFile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle = null): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(?string $caption): static
    {
        $this->caption = $caption;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;

    }

    public function setNom(string $nom = null): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getMime(): ?string
    {
        return $this->mime;
    }

    public function setMime(?string $mime): static
    {
        $this->mime = $mime;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(?int $taille): static
    {
        $this->taille = $taille;

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

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|null $imageFile
     */
    /*public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->dateModification = new \DateTimeImmutable();
        }
    }*/

    public function setImageFile(?File $imageFile = null, ?Oeuvre $oeuvre = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();

            // Set the Oeuvre object
            if (null !== $oeuvre) {
                $this->setOeuvre($oeuvre);
            }
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getThumbnailName(): string
    {
        return 'thumbnail_'.$this->nom;
    }

    public function setThumbnailName(string $thumbnailName = null): static
    {
        $this->thumbnailName = $thumbnailName;

        return $this;
    }

    public function getThumbnailFile(): ?File
    {
        return $this->thumbnailFile;
    }

    public function setThumbnailFile(?File $thumbnailFile = null): void
    {
        $this->thumbnailFile = $thumbnailFile;

        if (null !== $thumbnailFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}
