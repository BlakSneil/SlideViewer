<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Slide;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class PersonRepository extends EntityRepository
{
    public function newInstance()
    {
        return new Slide();
    }

    public function findAll($orderBy = null, $direction = 'ASC')
    {
        $qb = $this->createQueryBuilder('p');

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
        $qb = $this->createQueryBuilder('p');

        $qb->where('p.name LIKE :name')
            ->setParameter('name', '%' . $text . '%');

        if (null != $orderBy) {
            $qb->orderBy($orderBy, $direction);
        }

        return $qb->getQuery()->getResult();
    }
}
