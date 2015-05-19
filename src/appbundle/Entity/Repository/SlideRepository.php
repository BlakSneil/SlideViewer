<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Slide;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class SlideRepository extends EntityRepository
{
    public function newInstance()
    {
        return new Slide();
    }

    public function findAll($orderBy = null, $direction = 'ASC')
    {
        $qb = $this->createQueryBuilder($alias = 's');

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
        $qb = $this->createQueryBuilder($alias = 's');

        $qb->where('s.name LIKE :name')
            ->setParameter('name', '%' . $text . '%');

        if (null != $orderBy) {
            $qb->orderBy($orderBy, $direction);
        }

        return $qb->getQuery()->getResult();
    }
}
