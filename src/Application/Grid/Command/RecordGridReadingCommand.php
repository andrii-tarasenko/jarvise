<?php

namespace App\Application\Grid\Command;

class RecordGridReadingCommand
{
    public function __construct(
        public readonly ?float $gridPower,
        public readonly ?float $voltage,
        public readonly ?float $current,
        public readonly ?float $energy,
        public readonly ?float $frequency,
        public readonly ?float $power_f,
        public readonly ?float $solarPower,
    ) {}
}
