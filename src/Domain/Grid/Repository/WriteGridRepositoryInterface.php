<?php

namespace App\Domain\Grid\Repository;

use App\Entity\Grid;

interface WriteGridRepositoryInterface
{
    public function save(Grid $grid): void;
}
