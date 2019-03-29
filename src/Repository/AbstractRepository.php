<?php

namespace App\Repository;

use App\Entity\Phone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AbstractRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Phone::class);
    }
    
    protected function paginate(QueryBuilder $qb, $limit = 5, $offset = 0)
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
