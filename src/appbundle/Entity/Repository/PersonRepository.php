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

    public function findByName($text, $orderBy = null, $direction = 'ASC', $name = 'first_name')
    {
        return parent::findByName($text, $orderBy, $direction, $name);
    }
}