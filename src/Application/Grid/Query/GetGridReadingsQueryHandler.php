<?php

namespace App\Application\Grid\Query;

use Doctrine\DBAL\Connection;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use PDO;

#[AsMessageHandler]
class GetGridReadingsQueryHandler
{
    public function __construct(
        private Connection $connection
    ) {}

    /**
     * @return GridReadingView[]
     */
    public function __invoke(GetGridReadingsQuery $query): array
    {
        $sql = 'SELECT id, grid_power, solar_power, grid_power_day, invertor_power_day, grid_power_week, invertor_power_weel, grid_power_month, price, solal_price FROM grid ORDER BY id DESC LIMIT :limit';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('limit', $query->limit, PDO::PARAM_INT);
        $result = $stmt->executeQuery()->fetchAllAssociative();

        $views = [];
        foreach ($result as $row) {
            $views[] = new GridReadingView(
                (int) $row['id'],
                $row['grid_power'] !== null ? (float) $row['grid_power'] : null,
                $row['solar_power'] !== null ? (float) $row['solar_power'] : null,
                $row['grid_power_day'] !== null ? (float) $row['grid_power_day'] : null,
                $row['invertor_power_day'] !== null ? (float) $row['invertor_power_day'] : null,
                $row['grid_power_week'] !== null ? (float) $row['grid_power_week'] : null,
                $row['invertor_power_weel'] !== null ? (float) $row['invertor_power_weel'] : null,
                $row['grid_power_month'] !== null ? (float) $row['grid_power_month'] : null,
                (float) $row['price'],
                (float) $row['solal_price']
            );
        }

        return $views;
    }
}
