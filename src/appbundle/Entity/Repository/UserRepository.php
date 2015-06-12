<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class UserRepository extends EntityRepository
{
    public function newInstance()
    {
        return new User();
    }

    public function findAll($orderBy = null, $direction = 'ASC')
    {
        $qb = $this->createQueryBuilder($alias = 'u');

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
        $qb = $this->createQueryBuilder($alias = 'u');

        $qb->where('u.username LIKE :name')
            ->setParameter('name', '%' . $text . '%');

        if (null != $orderBy) {
            $qb->orderBy($orderBy, $direction);
        }

        return $qb->getQuery()->getResult();
    }
}
