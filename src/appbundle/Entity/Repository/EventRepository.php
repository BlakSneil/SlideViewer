<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Event;
use BS\CRUDBundle\Entity\Repository\BSBaseRepository;
use Doctrine\ORM\Query;

class EventRepository extends BSBaseRepository
{
    public function newInstance()
    {
        return new Event();
    }

    public function findAll($orderBy = null, $direction = 'ASC')
    {
        $qb = $this->createQueryBuilder($alias = 'e');

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

        $qb->where('e.name LIKE :name')
            ->setParameter('name', '%' . $text . '%');

        if (null != $orderBy) {
            $qb->orderBy($orderBy, $direction);
        }

        return $qb->getQuery()->getResult();
    }

    public function findAllWithPartecipations($member, $orderBy = null, $direction = 'ASC')
    {
        $qb = $this->createQueryBuilder($alias = 'e');

        $qb->select('e event, p.expected, p.happened')
            ->leftJoin('e.partecipations', 'p')
            ->where('p.member = :member OR p.member IS NULL')
            ->setParameter('member', $member);

        if (null != $orderBy) {
            $qb->orderBy($orderBy, $direction);
        }

        return $qb->getQuery()->getResult();
    }

    public function findByNameWithPartecipations($member, $text, $orderBy = null, $direction = 'ASC')
    {
        $qb = $this->createQueryBuilder($alias = 'e');

        $qb->select('e event, p.expected, p.happened')
            ->leftJoin('e.partecipations', 'p')
            ->where('p.member = :member OR p.member IS NULL')
            ->setParameter('member', $member);
            
        $qb->andWhere('e.name LIKE :name')
            ->setParameter('name', '%' . $text . '%');

        if (null != $orderBy) {
            $qb->orderBy($orderBy, $direction);
        }

        return $qb->getQuery()->getResult();
    }
}