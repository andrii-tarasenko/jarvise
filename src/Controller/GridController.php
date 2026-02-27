<?php

namespace App\Controller;

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
    public function __construct(private MessageBusInterface $messageBus) {}

    #[Route('/readings', name: 'api_grid_readings_get', methods: ['GET'])]
    public function getReadings(Request $request): JsonResponse
    {
        $limit = $request->query->getInt('limit', 50);
        $query = new GetGridReadingsQuery($limit);
        
        $envelope = $this->messageBus->dispatch($query);
        $result = $envelope->last(HandledStamp::class)->getResult();

        return $this->json($result);
    }

    #[Route('/readings', name: 'api_grid_readings_post', methods: ['POST'])]
    public function recordReading(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'Invalid JSON'], 400);
        }

        $command = new RecordGridReadingCommand(
            gridPower: $data['grid_power'] ?? null,
            solarPower: $data['solar_power'] ?? null,
            price: $data['price'] ?? 0.0,
            totalSolarPrice: $data['total_solar_price'] ?? null,
            totalGridPrice: $data['total_grid_price'] ?? null
        );

        $this->messageBus->dispatch($command);

        return $this->json(['status' => 'success'], 201);
    }
}
