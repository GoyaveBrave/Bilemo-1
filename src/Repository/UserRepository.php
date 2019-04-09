<?php

namespace App\Repository;

use App\Entity\Customer;

class UserRepository extends AbstractRepository
{
    public function search(Customer $customer, $term, $order = 'asc', $maxPerPage = 10, $currentPage = 1)
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->orderBy('u.id', $order);

        $qb->andWhere($qb->expr()->eq('u.customer', ':customer'))
            ->setParameter('customer', $customer);
        
        if (!empty($term)) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('u.username', ':term'),
                    $qb->expr()->like('u.email', ':term')
                )
            )
            ->setParameter('term', '%'.$term.'%');
        }
        
        return $this->paginate($qb, $maxPerPage, $currentPage);
    }
}
