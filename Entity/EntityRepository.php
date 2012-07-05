<?php

namespace Dime\TimetrackerBundle\Entity;

use Doctrine\ORM\EntityRepository as Base;
use Doctrine\ORM\QueryBuilder;

/**
 * EntityRepository
 *
 * Abstract repository to keep code clean.
 */
abstract class EntityRepository extends Base
{
    /**
     * @abstract
     *
     * @param string            $text
     * @param QueryBuilder      $qb
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    abstract public function search($text, QueryBuilder $qb);

    /**
     * @abstract
     *
     * @param                   $date
     * @param QueryBuilder      $qb
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    abstract public function scopeByDate($date, QueryBuilder $qb);

    /**
     * @param string            $field
     * @param string            $value
     * @param QueryBuilder|null $qb
     * @param string            $alias
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function scopeByField($field, $value, QueryBuilder $qb = null, $alias = 'e')
    {
        if ($qb == null) {
            $qb = $this->createQueryBuilder($alias);
        } else {
            $alias = $qb->getRootAliases();
            $alias = array_shift($alias);
        }

        $qb->andWhere($alias . '.' . $field . ' = :' . $field);
        $qb->setParameter($field, $value);

        return $qb;
    }

    public function filter(array $filter, \Doctrine\ORM\QueryBuilder $qb = null)
    {
        if ($filter != null) {
            foreach ($filter as $key => $value) {
                switch($key) {
                    case 'date':
                        // TODO Filter by date - no datetime functions at the moment
                        $qb = $this->scopeByDate($value, $qb);
                        break;
                    case 'search':
                        $qb = $this->search($value, $qb);
                        break;
                    default:
                        $qb = $this->scopeByField($key, $value, $qb);
                }
            }
        }
        return $qb;
    }
}
