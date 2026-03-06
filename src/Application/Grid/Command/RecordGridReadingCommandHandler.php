<?php

namespace App\Application\Grid\Command;

use App\Service\GridReadingCacheService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RecordGridReadingCommandHandler
{
    public function __construct(
        private GridReadingCacheService $cacheService
    ) {}

    public function __invoke(RecordGridReadingCommand $command): void
    {
        $this->cacheService->addReading($command);
    }
}
