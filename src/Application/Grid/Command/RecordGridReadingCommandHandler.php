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
        $grid->setPrice($command->price);
        // Assuming setters will be created or exist based on the entity
        if (method_exists($grid, 'setTotalSolarPrice')) {
             $grid->setTotalSolarPrice($command->totalSolarPrice);
        }
        if (method_exists($grid, 'setTotalGridPrice')) {
             $grid->setTotalGridPrice($command->totalGridPrice);
        }

        $this->repository->save($grid);
    }
}
