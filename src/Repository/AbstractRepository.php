<?php
/**
 * @author Sébastien Rochat <percevalseb@gmail.com>
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Class AbstractRepository.
 */
class AbstractRepository extends EntityRepository
{
    /**
     * @param QueryBuilder $qb
     * @param $maxPerPage
     * @param $currentPage
     *
     * @return Pagerfanta
     */
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
