<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Member;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class MemberRepository extends EntityRepository
{
    public function newInstance()
    {
        return new Member();
    }

    public function findAll($orderBy = null, $direction = 'ASC')
    {
        $qb = $this->createQueryBuilder($alias = 'm');

    	if ($orderBy == 'm.name') {
            $qb->orderBy('m.surname', $direction);
            $qb->orderBy('m.firstName', $direction);
    	} else if (null != $orderBy) {
            $qb->orderBy($orderBy, $direction);
        }

        return $qb->getQuery()->getResult();
    }

    public function findByName($text, $orderBy = null, $direction = 'ASC')
    {
        $qb = $this->createQueryBuilder($alias = 'm');

        $qb->where('CONCAT(m.firstName, m.surname) LIKE :name')
        	->orWhere('CONCAT(m.surname, m.firstName) LIKE :name')
            ->setParameter('name', '%' . str_replace(' ', '', $text) . '%');

    	if ($orderBy == 'm.name') {
            $qb->orderBy('m.surname', $direction);
            $qb->orderBy('m.firstName', $direction);
    	} else if (null != $orderBy) {
            $qb->orderBy($orderBy, $direction);
        }

        return $qb->getQuery()->getResult();
    }

    public function findByCell($idCell, $orderBy = null, $direction = 'ASC')
    {
        $qb = $this->createQueryBuilder($alias = 'm');

        $qb->where('m.cell_id LIKE :idCell')
            ->setParameter('idCell', $idCell);

        if ($orderBy == 'm.name') {
            $qb->orderBy('m.surname', $direction);
            $qb->orderBy('m.firstName', $direction);
        } else if (null != $orderBy) {
            $qb->orderBy($orderBy, $direction);
        }

        return $qb->getQuery()->getResult();
    }
}
