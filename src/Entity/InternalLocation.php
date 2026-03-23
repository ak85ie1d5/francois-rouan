<?php

namespace App\Entity;

use App\Repository\InternalLocationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: InternalLocationRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\Tree(type: 'nested')]
class InternalLocation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $RoomCode = null;

    #[ORM\Column(length: 50)]
    private ?string $RoomLabel = null;

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
    private Collection $children;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoomCode(): ?string
    {
        return $this->RoomCode;
    }

    public function setRoomCode(string $RoomCode): static
    {
        $this->RoomCode = $RoomCode;

        return $this;
    }

    public function getRoomLabel(): ?string
    {
        return $this->RoomLabel;
    }

    public function setRoomLabel(string $RoomLabel): static
    {
        $this->RoomLabel = $RoomLabel;

        return $this;
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
}
