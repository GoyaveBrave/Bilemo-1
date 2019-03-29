<?php

namespace App\Repository;

class UserRepository extends AbstractRepository
{
    public function search($term, $order = 'asc', $limit = 10, $offset = 0)
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->orderBy('u.id', $order);
        
        if (!empty($term)) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('u.username', ':term'),
                    $qb->expr()->like('u.email', ':term')
                )
            )
            ->setParameter('term', '%'.$term.'%');
        }
        
        return $this->paginate($qb, $limit, $offset);
    }
}
