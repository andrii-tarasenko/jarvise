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
}
