<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

use App\Application\Grid\Command\RecordGridReadingCommand;
use App\Application\Grid\Query\GetGridReadingsQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

#[Route('/api/v1/grid')]
final class GridController extends AbstractController
{
    public function __construct(
        private MessageBusInterface $messageBus,
        #[Autowire(service: 'monolog.logger.dev_custom')]
        private LoggerInterface $devCustomLogger,
    ) {}

    #[Route('/readings', name: 'api_grid_readings_get', methods: ['GET'])]
    public function getReadings(Request $request): JsonResponse
    {
        $limit = $request->query->getInt('limit', 10);
        $query = new GetGridReadingsQuery($limit);

        $envelope = $this->messageBus->dispatch($query);
        $result = $envelope->last(HandledStamp::class)->getResult();

        return $this->json($result);
    }

    #[Route('/stats', name: 'api_grid_stats_get', methods: ['GET'])]
    public function getStats(\App\Repository\GridRepository $repository): JsonResponse
    {
        return $this->json([
            'energyToday' => round($repository->getEnergySumForToday(), 3),
            'energyMonth' => round($repository->getEnergySumForCurrentMonth(), 3),
            'energyTotal' => round($repository->getTotalEnergySum(), 3),
            'frequency' => round($repository->getLastFrequency(), 3),
            'voltage' => round($repository->getLastVoltage(), 3),
        ]);
    }

    #[Route('/readings', name: 'api_grid_readings_post', methods: ['POST'])]
    public function recordReading(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $this->devCustomLogger->info('Got data from esp32', [
            'raw_data' => $data,
        ]);

        if (!$data) {
            return $this->json(['error' => 'Invalid JSON'], 400);
        }

        $command = new RecordGridReadingCommand(
            gridPower: $data['grid_power'] ?? 0.0,
            voltage: $data['voltage'] ?? 0.0,
            current: $data['current'] ?? 0.0,
            energy: $data['energy'] ?? 0.0,
            frequency: $data['frequency'] ?? 0.0,
            power_f: $data['power_f'] ?? 0.0,
            solarPower: $data['solar_power'] ?? null,
        );

        $this->messageBus->dispatch($command);

        return $this->json(['status' => 'success'], 201);
    }
}
