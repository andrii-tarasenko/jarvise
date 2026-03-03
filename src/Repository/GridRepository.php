<?php

namespace App\Repository;

use App\Entity\Grid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Domain\Grid\Repository\WriteGridRepositoryInterface;

/**
 * @extends ServiceEntityRepository<Grid>
 */
class GridRepository extends ServiceEntityRepository implements WriteGridRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Grid::class);
    }

    public function save(Grid $grid): void
    {
        $this->getEntityManager()->persist($grid);
        $this->getEntityManager()->flush();
    }

    public function getEnergySumForToday(): float
    {
        $startOfDay = (new \DateTimeImmutable())->setTime(0, 0, 0);

        return (float) $this->createQueryBuilder('g')
            ->select('SUM(g.energy) as totalEnergy')
            ->where('g.createdAt >= :startOfDay')
            ->setParameter('startOfDay', $startOfDay)
            ->getQuery()
            ->getSingleScalarResult() ?: 0.0;
    }

    public function getEnergySumForCurrentMonth(): float
    {
        $startOfMonth = (new \DateTimeImmutable('first day of this month'))->setTime(0, 0, 0);

        return (float) $this->createQueryBuilder('g')
            ->select('SUM(g.energy) as totalEnergy')
            ->where('g.createdAt >= :startOfMonth')
            ->setParameter('startOfMonth', $startOfMonth)
            ->getQuery()
            ->getSingleScalarResult() ?: 0.0;
    }

    public function getTotalEnergySum(): float
    {
        return (float) $this->createQueryBuilder('g')
            ->select('SUM(g.energy) as totalEnergy')
            ->getQuery()
            ->getSingleScalarResult() ?: 0.0;
    }

    public function getLastFrequency(): float
    {
        return (float) $this->createQueryBuilder('g')
            ->select('g.frequency')
            ->orderBy('g.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleScalarResult() ?: 0.0;
    }

    public function getLastVoltage(): float
    {
        return (float) $this->createQueryBuilder('g')
            ->select('g.voltage')
            ->orderBy('g.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleScalarResult() ?: 0.0;
    }
}
