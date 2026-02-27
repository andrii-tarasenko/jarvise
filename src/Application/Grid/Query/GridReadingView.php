<?php

namespace App\Application\Grid\Query;

class GridReadingView
{
    public function __construct(
        public readonly int $id,
        public readonly ?float $gridPower,
        public readonly ?float $solarPower,
        public readonly ?float $gridPowerDay,
        public readonly ?float $invertorPowerDay,
        public readonly ?float $gridPowerWeek,
        public readonly ?float $invertorPowerWeek,
        public readonly ?float $gridPowerMonth,
        public readonly float $price,
        public readonly float $solalPrice
    ) {}
}
