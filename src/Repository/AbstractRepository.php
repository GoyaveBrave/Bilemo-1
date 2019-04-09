<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class AbstractRepository extends EntityRepository
{
    protected function paginate(QueryBuilder $qb, $maxPerPage, $currentPage)
    {
        if (0 === $maxPerPage || 0 === $currentPage) {
            throw new \LogicException('$maxPerPage & $currentPage must be greater than 0.');
        }

        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pagerfanta->setMaxPerPage((int) $maxPerPage)
            ->setCurrentPage($currentPage);

        return $pagerfanta;
    }
}
