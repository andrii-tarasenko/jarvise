<?php

namespace App\Command;

use App\Entity\Grid;
use App\Domain\Grid\Repository\WriteGridRepositoryInterface;
use App\Service\GridReadingCacheService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:flush-grid-readings',
    description: 'Flushes cached power readings to the database when 1 hour of data has been collected.',
)]
class FlushGridReadingsCacheCommand extends Command
{
    public function __construct(
        private GridReadingCacheService $cacheService,
        private WriteGridRepositoryInterface $repository,
        private LoggerInterface $logger,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(
            'min-minutes',
            null,
            InputOption::VALUE_OPTIONAL,
            'Minimum minutes of data required before flushing (default: 60)',
            60
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $minMinutes = (int)$input->getOption('min-minutes');

        $readings = $this->cacheService->getReadings();

        if (empty($readings)) {
            $message = 'Cache is empty — no readings to flush.';
            $output->writeln($message);
            $this->logger->info($message);
            return Command::SUCCESS;
        }

        if (!$this->cacheService->hasEnoughData($minMinutes)) {
            $oldest = $readings[0]['timestamp'];
            $newest = end($readings)['timestamp'];
            $message = sprintf(
                'Not enough data yet (%d readings, oldest: %s, newest: %s). Waiting for %d minutes of data.',
                count($readings),
                $oldest,
                $newest,
                $minMinutes
            );
            $output->writeln($message);
            $this->logger->info($message);
            return Command::SUCCESS;
        }

        // --- Aggregate readings ---
        $count = count($readings);

        $avgPower = $this->avg($readings, 'grid_power');
        $avgVoltage = $this->avg($readings, 'voltage');
        $avgCurrent = $this->avg($readings, 'current');
        $avgFrequency = $this->avg($readings, 'frequency');
        $avgPowerF = $this->avg($readings, 'power_f');
        $avgSolar = $this->avg($readings, 'solar_power');

        // Energy: difference between last and first reading (accumulative counter)
        $energyFirst = (float)$readings[0]['energy'];
        $energyLast = (float)end($readings)['energy'];
        $energyDelta = $energyLast - $energyFirst;
        // Safeguard: if sensor was reset the delta may be negative — fall back to avg
        if ($energyDelta < 0) {
            $energyDelta = $this->avg($readings, 'energy');
        }

        $grid = new Grid();
        $grid->setGridPower($avgPower);
        $grid->setGridVoltage($avgVoltage);
        $grid->setGridCurrent($avgCurrent);
        $grid->setGridEnergy($energyDelta);
        $grid->setGridFrequency($avgFrequency);
        $grid->setGridPowerFactor($avgPowerF);
        $grid->setSolarPower($avgSolar);
        $grid->setPrice();

        $this->repository->save($grid);
        $this->cacheService->clearReadings();

        $message = sprintf(
            'Flushed %d readings to DB. Energy delta: %.4f kWh, avg power: %.2f W.',
            $count,
            $energyDelta,
            $avgPower
        );
        $output->writeln($message);
        $this->logger->info($message, [
            'count' => $count,
            'energy_delta' => $energyDelta,
            'avg_power' => $avgPower,
        ]);

        return Command::SUCCESS;
    }

    /**
     * Compute the average of a numeric field across all readings.
     *
     * @param array<int, array<string, mixed>> $readings
     */
    private function avg(array $readings, string $field): float
    {
        $values = array_filter(
            array_column($readings, $field),
            fn($v) => $v !== null
        );

        if (empty($values)) {
            return 0.0;
        }

        return array_sum($values) / count($values);
    }
}
