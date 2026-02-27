<?php

namespace App\Application\Grid\Query;

use App\Entity\Grid;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetGridReadingsQueryHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * @return GridReadingView[]
     */
    public function __invoke(GetGridReadingsQuery $query): array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $grids = $qb->select('g')
            ->from(Grid::class, 'g')
            ->orderBy('g.id', 'DESC')
            ->setMaxResults($query->limit)
            ->getQuery()
            ->getResult();

        $views = [];
        foreach ($grids as $grid) {
            $views[] = new GridReadingView(
                $grid->getId(),
                $grid->getCreatedAt()->format('Y-m-d H:i:s'),
                $grid->getGridPower(),
                $grid->getSolarPower(),
                $grid->getPrice(),
                method_exists($grid, 'getTotalSolarPrice') ? $grid->getTotalSolarPrice() : null,
                method_exists($grid, 'getTotalGridPrice') ? $grid->getTotalGridPrice() : null
            );
        }

        return $views;
    }
}
