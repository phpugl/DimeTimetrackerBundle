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
     * Scope by any field with value
     *
     * @param string                     $field
     * @param string                     $value
     * @param \Doctrine\ORM\QueryBuilder $qb
     *
     * @return \Doctrine\ORM\QueryBuilder
     * @throws \Exception when $qb is null
     */
    public function scopeByField($field, $value, QueryBuilder $qb)
    {
        if ($qb == null) {
            throw \Exception("QueryBuilder must be set");
        }

        $aliases = $qb->getRootAliases();
        $alias = array_shift($aliases);

        $qb->andWhere(
            $qb->expr()->eq($alias . '.' . $field, ':' . $field)
        );
        $qb->setParameter($field, $value);

        return $qb;
    }

    /**
     * Add different filter option to query
     *
     * @param array                      $filter
     * @param \Doctrine\ORM\QueryBuilder $qb
     *
     * @return \Doctrine\ORM\QueryBuilder
     * @throws \Exception when $qb is null
     */
    public function filter(array $filter, QueryBuilder $qb)
    {
        if ($qb == null) {
            throw \Exception("QueryBuilder must be set");
        }

        if ($filter != null) {
            foreach ($filter as $key => $value) {
                switch($key) {
                    case 'date':
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

    /**
     * Check if a join alias already taken. getRootAliases() doesn't do this for me.
     *
     * @param \Doctrine\ORM\QueryBuilder $qb, QueryBuilder you wanne check
     * @param                            $alias, alias string
     *
     * @return bool
     */
    public function existsJoinAlias(QueryBuilder $qb, $alias)
    {
        $result = false;

        foreach ($qb->getDQLPart('join') as $joins) {
            foreach ($joins as $j) {
                $join = $j->__toString();
                if (substr($join, strrpos($join, ' ') + 1) == $alias) {
                    $result = true;
                    break;
                }
            }
            if ($result) {
                break;
            }
        }

        return $result;
    }
}
