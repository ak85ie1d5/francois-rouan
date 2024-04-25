<?php

namespace App\Entity;

use App\Entity\Trait\TimeColumnTrait;
use App\Entity\Trait\UserColumnTrait;
use App\Repository\ArtworkCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Umanit\EasyAdminTreeBundle\Entity\AbstractTreeItem;

#[ORM\Entity(repositoryClass: ArtworkCategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ArtworkCategory extends AbstractTreeItem
{
    use TimeColumnTrait;
    use UserColumnTrait;

    /**
     * @var Collection<int, Oeuvre>
     */
    #[ORM\OneToMany(mappedBy: 'ArtworkCategory', targetEntity: Oeuvre::class)]
    private Collection $oeuvres;

    public function __construct()
    {
        $this->oeuvres = new ArrayCollection();
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
            $oeuvre->setArtworkCategory($this);
        }

        return $this;
    }

    public function removeOeuvre(Oeuvre $oeuvre): static
    {
        if ($this->oeuvres->removeElement($oeuvre)) {
            // set the owning side to null (unless already changed)
            if ($oeuvre->getArtworkCategory() === $this) {
                $oeuvre->setArtworkCategory(null);
            }
        }

        return $this;
    }
}
