<?php

namespace App\Application\Grid\Command;

class RecordGridReadingCommand
{
    public function __construct(
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
