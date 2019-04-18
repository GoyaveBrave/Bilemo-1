<?php
/**
 * @author Sébastien Rochat <percevalseb@gmail.com>
 */

namespace App\Repository;

/**
 * Class PhoneRepository.
 */
class PhoneRepository extends AbstractRepository
{
    /**
     * @param $term
     * @param string $order
     * @param int    $maxPerPage
     * @param int    $currentPage
     *
     * @return \Pagerfanta\Pagerfanta
     */
    public function search($term, $order = 'asc', $maxPerPage = 5, $currentPage = 1)
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

        return $this->paginate($qb, $maxPerPage, $currentPage);
    }
}
