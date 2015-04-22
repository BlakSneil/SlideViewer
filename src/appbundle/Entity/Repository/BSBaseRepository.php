<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\BaseClass;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class BSBaseRepository extends EntityRepository implements BSRepositoryInterface
{
    public function newInstance()
    {
        return new BaseClass();
    }

    public function findAll($orderBy = null, $direction = 'ASC')
    {
        $qb = $this->createQueryBuilder($alias = 'b');

        if (null != $orderBy) {
            $qb->orderBy($orderBy, $direction);
        }

        return $qb->getQuery()->getResult();
    }

    public function findById($id)
    {
        return $this->find($id);
    }

    public function findByName($text, $orderBy = null, $direction = 'ASC')
    {
        $qb = $this->createQueryBuilder($alias = 'e');

        $qb->where('b.name LIKE :name')
            ->setParameter('name', '%' . $text . '%');

        if (null != $orderBy) {
            $qb->orderBy($orderBy, $direction);
        }

        return $qb->getQuery()->getResult();
    }
}
