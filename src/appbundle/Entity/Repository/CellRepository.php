<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Cell;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class CellRepository extends EntityRepository
{
    public function newInstance()
    {
        return new Cell();
    }
}
