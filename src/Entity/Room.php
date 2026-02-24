<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $lightOn = null;

    #[ORM\Column]
    private ?float $atemperature = null;

    #[ORM\Column]
    private ?float $noiseLevel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isLightOn(): ?bool
    {
        return $this->lightOn;
    }

    public function setLightOn(bool $lightOn): static
    {
        $this->lightOn = $lightOn;

        return $this;
    }

    public function getAtemperature(): ?float
    {
        return $this->atemperature;
    }

    public function setAtemperature(float $atemperature): static
    {
        $this->atemperature = $atemperature;

        return $this;
    }

    public function getNoiseLevel(): ?float
    {
        return $this->noiseLevel;
    }

    public function setNoiseLevel(float $noiseLevel): static
    {
        $this->noiseLevel = $noiseLevel;

        return $this;
    }
}
