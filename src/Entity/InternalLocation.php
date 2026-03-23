<?php

namespace App\Entity;

use App\Repository\InternalLocationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InternalLocationRepository::class)]
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
}
