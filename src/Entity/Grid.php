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

    #[ORM\Column(nullable: true)]
    private ?float $grid_power = null;

    #[ORM\Column(nullable: true)]
    private ?float $solar_power = null;

    #[ORM\Column(nullable: true)]
    private ?float $grid_power_day = null;

    #[ORM\Column(nullable: true)]
    private ?float $invertor_power_day = null;

    #[ORM\Column(nullable: true)]
    private ?float $grid_power_week = null;

    #[ORM\Column(nullable: true)]
    private ?float $invertor_power_weel = null;

    #[ORM\Column(nullable: true)]
    private ?float $grid_power_month = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?float $solal_price = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSolarPower(): ?float
    {
        return $this->solar_power;
    }

    public function setSolarPower(?float $solar_power): static
    {
        $this->solar_power = $solar_power;

        return $this;
    }

    public function getgridPowerDay(): ?float
    {
        return $this->grid_power_day;
    }

    public function setgridPowerDay(?float $grid_power_day): static
    {
        $this->grid_power_day = $grid_power_day;

        return $this;
    }

    public function getInvertorPowerDay(): ?float
    {
        return $this->invertor_power_day;
    }

    public function setInvertorPowerDay(?float $invertor_power_day): static
    {
        $this->invertor_power_day = $invertor_power_day;

        return $this;
    }

    public function getGridPowerWeek(): ?float
    {
        return $this->grid_power_week;
    }

    public function setGridPowerWeek(?float $grid_power_week): static
    {
        $this->grid_power_week = $grid_power_week;

        return $this;
    }

    public function getInvertorPowerWeel(): ?float
    {
        return $this->invertor_power_weel;
    }

    public function setInvertorPowerWeel(?float $invertor_power_weel): static
    {
        $this->invertor_power_weel = $invertor_power_weel;

        return $this;
    }

    public function getGridPowerMonth(): ?float
    {
        return $this->grid_power_month;
    }

    public function setGridPowerMonth(?float $grid_power_month): static
    {
        $this->grid_power_month = $grid_power_month;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getSolalPrice(): ?float
    {
        return $this->solal_price;
    }

    public function setSolalPrice(float $solal_price): static
    {
        $this->solal_price = $solal_price;

        return $this;
    }
}
