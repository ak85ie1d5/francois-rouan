<?php

namespace App\Entity;

use App\Repository\GroupeOeuvreCategoriePermRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupeOeuvreCategoriePermRepository::class)]
class GroupeOeuvreCategoriePerm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'groupeOeuvreCategoriePerms')]
    private ?Groupe $groupe = null;

    #[ORM\ManyToOne(inversedBy: 'groupeOeuvreCategoriePerms')]
    private ?OeuvreCategorie $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): static
    {
        $this->groupe = $groupe;

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
}
