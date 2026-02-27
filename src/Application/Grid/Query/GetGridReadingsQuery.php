<?php

namespace App\Application\Grid\Query;

class GetGridReadingsQuery
{
    public function __construct(
        public readonly int $limit = 100
    ) {}
}
