<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class AbstractRepository extends EntityRepository
{
    protected function paginate(QueryBuilder $qb, $limit, $offset = 0)
    {
        if (0 === $limit || 0 === $offset) {
            throw new \LogicException('$limit & $offset must be greater than 0.');
        }

        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($qb));
        $currentPage = ceil(((int) $offset + 1) / (int) $limit);

        $pagerfanta->setMaxPerPage((int) $limit)
            ->setCurrentPage($currentPage);

        return $pagerfanta;
    }
}
