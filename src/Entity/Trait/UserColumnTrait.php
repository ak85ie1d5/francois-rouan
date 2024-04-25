<?php

namespace App\Entity\Trait;

use App\Entity\Utilisateur;
use Doctrine\ORM\Mapping as ORM;

trait UserColumnTrait
{
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $createdBy;

    #[ORM\ManyToOne]
    private ?Utilisateur $updatedBy = null;

    public function getCreatedBy(): ?Utilisateur
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?Utilisateur $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy(): ?Utilisateur
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?Utilisateur $updatedBy): static
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

}