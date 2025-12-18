<?php

namespace App\Entity;

use App\Entity\Trait\TimeColumnTrait;
use App\Entity\Trait\UserColumnTrait;
use App\Repository\ArtworkCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: ArtworkCategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\Tree(type: 'nested')]
class ArtworkCategory
{
    use TimeColumnTrait;
    use UserColumnTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Gedmo\TreeLeft]
    #[ORM\Column(type: 'integer')]
    private ?int $lft = null;

    #[Gedmo\TreeLevel]
    #[ORM\Column(type: 'integer')]
    private ?int $lvl = null;

    #[Gedmo\TreeRight]
    #[ORM\Column(type: 'integer')]
    private ?int $rgt = null;

    #[Gedmo\TreeRoot]
    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?self $root = null;

    #[Gedmo\TreeParent]
    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[ORM\JoinColumn(referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    #[ORM\OrderBy(['lft' => 'ASC'])]
    private Collection $children;

    /**
     * @var Collection<int, Oeuvre>
     */
    #[ORM\OneToMany(mappedBy: 'ArtworkCategory', targetEntity: Oeuvre::class)]
    private Collection $oeuvres;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->oeuvres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLft(): ?int
    {
        return $this->lft;
    }

    public function setLft(?int $lft): static
    {
        $this->lft = $lft;
        return $this;
    }

    public function getLvl(): ?int
    {
        return $this->lvl;
    }

    public function setLvl(?int $lvl): static
    {
        $this->lvl = $lvl;
        return $this;
    }

    public function getRgt(): ?int
    {
        return $this->rgt;
    }

    public function setRgt(?int $rgt): static
    {
        $this->rgt = $rgt;
        return $this;
    }

    public function getRoot(): ?self
    {
        return $this->root;
    }

    public function setRoot(?self $root): static
    {
        $this->root = $root;
        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;
        return $this;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }
        return $this;
    }

    public function removeChild(self $child): static
    {
        if ($this->children->removeElement($child)) {
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }
        return $this;
    }

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
            if ($oeuvre->getArtworkCategory() === $this) {
                $oeuvre->setArtworkCategory(null);
            }
        }
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
