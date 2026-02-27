<?php

namespace App\Application\Grid\Command;

use App\Domain\Grid\Repository\WriteGridRepositoryInterface;
use App\Entity\Grid;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RecordGridReadingCommandHandler
{
    public function __construct(
        private WriteGridRepositoryInterface $repository
    ) {}

    public function __invoke(RecordGridReadingCommand $command): void
    {
        $grid = new Grid();
        $grid->setGridPower($command->gridPower);
        $grid->setSolarPower($command->solarPower);
        $grid->setgridPowerDay($command->gridPowerDay);
        $grid->setInvertorPowerDay($command->invertorPowerDay);
        $grid->setGridPowerWeek($command->gridPowerWeek);
        $grid->setInvertorPowerWeel($command->invertorPowerWeek);
        $grid->setGridPowerMonth($command->gridPowerMonth);
        $grid->setPrice($command->price);
        $grid->setSolalPrice($command->solalPrice);

        $this->repository->save($grid);
    }
}
