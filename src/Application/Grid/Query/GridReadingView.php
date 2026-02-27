<?php

namespace App\Application\Grid\Query;

class GridReadingView
{
    public function __construct(
        public readonly int $id,
        public readonly string $createdAt,
        public readonly ?float $gridPower,
        public readonly ?float $solarPower,
        public readonly float $price,
        public readonly ?float $totalSolarPrice,
        public readonly ?float $totalGridPrice
    ) {}
}
