<?php

namespace App\Application\Grid\Command;

class RecordGridReadingCommand
{
    public function __construct(
        public readonly ?float $gridPower,
        public readonly ?float $solarPower,
        public readonly float $price,
        public readonly ?float $totalSolarPrice,
        public readonly ?float $totalGridPrice
    ) {}
}
