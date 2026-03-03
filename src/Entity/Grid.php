<?php

namespace App\Entity;

use App\Repository\GridRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GridRepository::class)]
class Grid
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    #[ORM\Column(nullable: true)]
    private ?float $grid_power = null;

    #[ORM\Column(nullable: true)]
    private ?float $voltage = null;

    #[ORM\Column(nullable: true)]
    private ?float $current = null;

    #[ORM\Column(nullable: true)]
    private ?float $energy = null;

    #[ORM\Column(nullable: true)]
    private ?float $frequency = null;

    #[ORM\Column(nullable: true)]
    private ?float $power_f = null;

    #[ORM\Column(nullable: true)]
    private ?float $solar_power = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    private ?float $total_solar_price = null;

    #[ORM\Column(nullable: true)]
    private ?float $total_grid_price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getGridPower(): ?float
    {
        return $this->grid_power;
    }

    public function setGridPower(?float $grid_power): static
    {
        $this->grid_power = $grid_power;

        return $this;
    }

    public function setGridVoltage(?float $voltage): static
    {
        $this->voltage = $voltage;

        return $this;
    }

    public function getGridVoltage(): ?float
    {
        return $this->voltage;
    }

    public function setGridCurrent(?float $current): static
    {
        $this->current = $current;

        return $this;
    }

    public function getGridCurrent(): ?float
    {
        return $this->current;
    }

    public function setGridEnergy(?float $energy): static
    {
        $this->energy = $energy;

        return $this;
    }

    public function getGridEnergy(): ?float
    {
        return $this->energy;
    }

    public function setGridFrequency(?float $frequency): static
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getGridFrequency(): ?float
    {
        return $this->frequency;
    }

    public function setGridPowerFactor(?float $power_f): static
    {
        $this->power_f = $power_f;

        return $this;
    }

    public function getGridPowerFactor(): ?float
    {
        return $this->power_f;
    }

    public function getSolarPower(): ?float
    {
        return $this->solar_power;
    }

    public function setSolarPower(?float $solar_power): static
    {
        $this->solar_power = $solar_power;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(): static
    {
        $this->price = 4.5;

        return $this;
    }
}
