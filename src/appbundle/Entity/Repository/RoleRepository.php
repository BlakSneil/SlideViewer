<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Role;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class RoleRepository extends EntityRepository
{
    public function newInstance()
    {
        return new Role();
    }

    public function findAll($orderBy = null, $direction = 'ASC')
    {
        $qb = $this->createQueryBuilder($alias = 'r');

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
        $qb = $this->createQueryBuilder($alias = 'r');

        $qb->where('r.name LIKE :name')
            ->setParameter('name', '%' . $text . '%');

        if (null != $orderBy) {
            $qb->orderBy($orderBy, $direction);
        }

        return $qb->getQuery()->getResult();
    }
}
