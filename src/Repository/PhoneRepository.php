<?php

namespace App\Repository;

class PhoneRepository extends AbstractRepository
{
    public function search($term, $order = 'asc', $limit = 5, $offset = 0)
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.id', $order);
        
        if (!empty($term)) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('p.name', ':term'),
                    $qb->expr()->like('p.brand', ':term')
                )
            )
            ->setParameter('term', '%'.$term.'%');
        }
        
        return $this->paginate($qb, $limit, $offset);
    }
}
