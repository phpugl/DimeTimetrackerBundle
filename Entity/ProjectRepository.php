<?php

namespace Dime\TimetrackerBundle\Entity;

use Dime\TimetrackerBundle\Entity\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends EntityRepository
{

    public function scopeByCustomer($id, QueryBuilder $qb = null, $alias = 'p')
    {
        if ($qb == null) {
            $qb = $this->createQueryBuilder($alias);
        } else {
            $alias = $qb->getRootAliases();
            $alias = array_shift($alias);
        }

        $qb->andWhere($alias . '.customer = :customer');
        $qb->setParameter('customer', $id);

        return $qb;
    }
}
