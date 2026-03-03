<?php

namespace App\Application\Grid\Query;

class GridReadingView
{
    public function __construct(
        public readonly int $id,
        public readonly string $createdAt,
        public readonly ?float $gridPower,
        public readonly bool $isGridActive,
        public readonly ?float $voltage,
        public readonly ?float $current,
        public readonly ?float $energy,
        public readonly ?float $frequency,
        public readonly ?float $power_f,
        public readonly ?float $solarPower,
        public readonly float $price,
//        public readonly ?float $totalSolarPrice,
//        public readonly ?float $totalGridPrice
    ) {}
}
