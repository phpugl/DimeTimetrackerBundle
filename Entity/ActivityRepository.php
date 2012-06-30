<?php

namespace Dime\TimetrackerBundle\Entity;

use Dime\TimetrackerBundle\Entity\EntityRepository;
use Doctrine\ORM\QueryBuilder;
/**
 * ActivityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ActivityRepository extends EntityRepository
{
    public function scopeByDate($date, QueryBuilder $qb = null, $alias = 'a')
    {
        if ($qb == null) {
            $qb = $this->createQueryBuilder($alias);
        } else {
            $alias = $qb->getRootAliases();
            $alias = array_shift($alias);
        }

        $qb->leftJoin('a.timeslices', 't');
        if (is_array($date)) {
            $qb->andWhere($qb->expr()->orX($qb->expr()->between('a.updatedAt', ':from', ':to'), $qb->expr()->between('t.startedAt', ':from', ':to')));
            $qb->setParameter(':from', $date[0]);
            $qb->setParameter(':to', $date[1]);
        } else {
            $qb->andWhere($qb->expr()->orX($qb->expr()->like('a.updatedAt', ':date'), $qb->expr()->like('t.startedAt', ':date')));
            $qb->setParameter('date', $date . '%');
        }

        return $qb;
    }

    public function scopeByField($field, $value, QueryBuilder $qb = null, $alias = 'a')
    {
        if ($qb == null) {
            $qb = $this->createQueryBuilder($alias);
        } else {
            $alias = $qb->getRootAliases();
            $alias = array_shift($alias);
        }

        $qb->andWhere($alias . '.' . $field . ' = :value');
        $qb->setParameter('value', $value);

        return $qb;
    }

    public function scopeByCustomer($id, QueryBuilder $qb = null, $alias = 'a')
    {
        return $this->scopeByField('customer', $id, $qb, $alias);
    }

    public function scopeByProject($id, QueryBuilder $qb = null, $alias = 'a')
    {
        return $this->scopeByField('project', $id, $qb, $alias);
    }

    public function scopeByService($id, QueryBuilder $qb = null, $alias = 'a')
    {
        return $this->scopeByField('service', $id, $qb, $alias);
    }
}
