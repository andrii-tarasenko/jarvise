<?php

namespace App\Service;

use App\Application\Grid\Command\RecordGridReadingCommand;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class GridReadingCacheService
{
    private const CACHE_KEY = 'grid_readings_buffer';

    public function __construct(
        private CacheInterface $cache
    )
    {
    }

    /**
     * Add a new reading to the buffer with the current timestamp.
     */
    public function addReading(RecordGridReadingCommand $command): void
    {
        $readings = $this->getReadings();

        $readings[] = [
            'timestamp' => (new \DateTimeImmutable())->format(\DateTimeInterface::ATOM),
            'grid_power' => $command->gridPower,
            'voltage' => $command->voltage,
            'current' => $command->current,
            'energy' => $command->energy,
            'frequency' => $command->frequency,
            'power_f' => $command->power_f,
            'solar_power' => $command->solarPower,
        ];

        // Delete then recompute the cache item so we can update the stored list.
        $this->cache->delete(self::CACHE_KEY);

        $readingsCopy = $readings;
        $this->cache->get(self::CACHE_KEY, function (ItemInterface $item) use ($readingsCopy) {
            // Keep the buffer for 25 hours so it survives multiple flush cycles.
            $item->expiresAfter(90000);
            return $readingsCopy;
        });
    }

    /**
     * Return all buffered readings.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getReadings(): array
    {
        return $this->cache->get(self::CACHE_KEY, function (ItemInterface $item) {
            $item->expiresAfter(90000);
            return [];
        });
    }

    /**
     * Clear the buffer entirely.
     */
    public function clearReadings(): void
    {
        $this->cache->delete(self::CACHE_KEY);
    }

    /**
     * Returns true when the buffered readings span at least $minutes minutes.
     */
    public function hasEnoughData(int $minutes = 60): bool
    {
        $readings = $this->getReadings();

        if (count($readings) < 2) {
            return false;
        }

        $oldest = new \DateTimeImmutable($readings[0]['timestamp']);
        $newest = new \DateTimeImmutable(end($readings)['timestamp']);

        $diffSeconds = $newest->getTimestamp() - $oldest->getTimestamp();

        return $diffSeconds >= ($minutes * 60);
    }
}
